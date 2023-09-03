<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersDevSeeder extends Seeder
{
    const USER_NAME_PREFIX = 'RandomUser';

    const USER_EMAIL_PREFIX = 'random_user_';

    const USER_EMAIL_SUFFIX = '@example.com';

    public function run(): void
    {
        $usersCount = random_int(300, 500);
        $usersData = [];

        for ($id = 1; $id <= $usersCount; $id++) {
            $createdAt = Carbon::today()->subDays(random_int(90, 270));

            $usersData[] = [
                'id' => $id,
                'name' => static::USER_NAME_PREFIX.$id,
                'email' => static::USER_EMAIL_PREFIX.$id.static::USER_EMAIL_SUFFIX,
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
                'email_verified_at' => $createdAt,
            ];
        }

        User::insert($usersData);
    }
}
