<?php

namespace Database\Seeders;

use App\Models\Follower;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StreamerEventsDevSeeder extends Seeder
{
    private array $userIds;

    private array $famousUserIds;

    public function run(): void
    {
        $this->userIds = User::pluck('id')->toArray();
        $this->famousUserIds = array_filter(
            $this->userIds,
            fn () => random_int(1, 9) === 1
        );

        $followers = [];

        foreach ($this->famousUserIds as $userId) {
            foreach ($this->userIds as $followerId) {
                if($userId === $followerId) {
                    continue;
                }

                $followers[] = [
                    'user_id' => $userId,
                    'follower_id' => $followerId,
                    'read' => false,
                    'created_at' => Carbon::today()->subDays(random_int(0, 90)),
                ];
            }
        }

        Follower::insert($followers);
    }
}
