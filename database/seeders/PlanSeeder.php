<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('plans')->updateOrInsert(
            ['code' => 'basic'],
            [
                'name' => 'Basic',
                'otp_daily_limit' => 30,
                'otp_ip_10m_limit' => 20,
                'otp_phone_60s_lock' => 60,
                'otp_verify_5m_limit' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('plans')->updateOrInsert(
            ['code' => 'pro'],
            [
                'name' => 'Pro',
                'otp_daily_limit' => 200,
                'otp_ip_10m_limit' => 60,
                'otp_phone_60s_lock' => 60,
                'otp_verify_5m_limit' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        DB::table('plans')->updateOrInsert(
            ['code' => 'enterprise'],
            [
                'name' => 'Enterprise',
                'otp_daily_limit' => 1000000,
                'otp_ip_10m_limit' => 300,
                'otp_phone_60s_lock' => 30,
                'otp_verify_5m_limit' => 20,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
