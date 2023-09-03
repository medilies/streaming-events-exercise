<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionTiersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subscription_tiers')->insert([
            [
                'name' => 'Tier 1',
                'amount' => 5,
                'currency' => 'USD',
            ],
            [
                'name' => 'Tier 2',
                'amount' => 10,
                'currency' => 'USD',
            ],
            [
                'name' => 'Tier 3',
                'amount' => 15,
                'currency' => 'USD',
            ],
        ]);
    }
}
