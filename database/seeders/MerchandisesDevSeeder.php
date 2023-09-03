<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerchandisesDevSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('merchandises')->insert([
            [
                'name' => 'Cup',
                'price' => 5,
                'currency' => 'USD',
            ],
            [
                'name' => 'Cap',
                'price' => 10,
                'currency' => 'USD',
            ],
            [
                'name' => 'Fancy pants',
                'price' => 15,
                'currency' => 'USD',
            ],
        ]);
    }
}
