<?php

namespace App\Http\Controllers;

use App\Models\Firm;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\RegistrationToken;
use App\Models\Transaction;
use App\Services\AuditLogger;
use App\Services\Sms\SmsApiSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FirmController extends Controller
{
    private function firm(): Firm
    {
        $firm = Auth::guard('company')->user();

        if (!$firm) {
            abort(403, 'Brak zalogowanej firmy');
        }

        return $firm;
    }

    public function dashboard()
    {
        $firm = $this->firm();

        $totalClients = LoyaltyCard::where('firm_id', $firm->id)
            ->distinct('client_id')
            ->count('client_id');

        $totalTransactions = Transaction::where('firm_id', $firm->id)->count();
        $totalPoints = LoyaltyStamp::where('firm_id', $firm->id)->count();

        return view('firm.dashboard', compact(
            'totalClients',
            'totalTransactions',
            'totalPoints'
        ));
    }

    public function showPointsForm()
    {
        $firm = $this->firm();

        $settings = DB::table('program_settings')
            ->where('firm_id', $firm->id)
            ->first();

        return view('firm.points.index', compact('settings'));
    }

    public function showAddClientPointsForm()
    {
        return view('firm.points.add-client');
    }

    public function storeClientPoints(Request $request)
    {
        $firm = $this->firm();

        $request->validate([
            'phone' => 'required|string',
            'amount' => 'required|integer|min:1',
        ]);

        $phone = preg_replace('/\D+/', '', $request->phone);

        if (strlen($phone) === 11 && str_starts_with($phone, '48')) {
            $phone = substr($phone, 2);
        }

        $client = DB::table('clients')->where('phone', $phone)->first();

        if (!$client) {
            return back()->withErrors(['phone' => 'Klient nie istnieje']);
        }

        $settings = DB::table('program_settings')
            ->where('firm_id', $firm->id)
            ->first();

        $divider = $settings->points_per_currency ?? 10;
        $points = (int) floor($request->amount / $divider);

        $existing = DB::table('client_points')
            ->where('client_id', $client->id)
            ->where('firm_id', $firm->id)
            ->first();

        if ($existing) {
            DB::table('client_points')
                ->where('client_id', $client->id)
                ->where('firm_id', $firm->id)
                ->update([
                    'points' => $existing->points + $points,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('client_points')->insert([
                'client_id' => $client->id,
                'firm_id' => $firm->id,
                'points' => $points,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('client_point_logs')->insert([
            'client_id' => $client->id,
            'firm_id' => $firm->id,
            'points' => $points,
            'amount' => $request->amount,
            'created_at' => now(),
        ]);

        return back()->with('success', "Dodano {$points} punktów");
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 NOWE — REDEEM PUNKTÓW
    |--------------------------------------------------------------------------
    */
    public function redeemPoints(Request $request)
    {
        $firm = $this->firm();

        $request->validate([
            'client_id' => 'required|integer',
            'points' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $firm) {

            $row = DB::table('client_points')
                ->where('client_id', $request->client_id)
                ->where('firm_id', $firm->id)
                ->lockForUpdate()
                ->first();

            if (!$row) {
                throw new \Exception('Brak punktów');
            }

            if ($row->points < $request->points) {
                throw new \Exception('Za mało punktów');
            }

            DB::table('client_points')
                ->where('client_id', $request->client_id)
                ->where('firm_id', $firm->id)
                ->update([
                    'points' => $row->points - $request->points,
                    'updated_at' => now(),
                ]);

            DB::table('client_point_logs')->insert([
                'client_id' => $request->client_id,
                'firm_id' => $firm->id,
                'points' => -$request->points,
                'amount' => 0,
                'created_at' => now(),
            ]);
        });

        return back()->with('success', 'Zrealizowano rabat');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 NOWE — POBIERANIE NAGRÓD
    |--------------------------------------------------------------------------
    */
    public function getRewards($clientId)
    {
        $firm = $this->firm();

        $points = DB::table('client_points')
            ->where('client_id', $clientId)
            ->where('firm_id', $firm->id)
            ->value('points') ?? 0;

        $rewards = DB::table('point_rewards')
            ->where('firm_id', $firm->id)
            ->orderBy('points_required')
            ->get()
            ->filter(fn($r) => $points >= $r->points_required);

        return [
            'points' => $points,
            'rewards' => $rewards,
        ];
    }
}
