<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Follower;
use App\Models\Merchandise;
use App\Models\MerchandiseSale;
use App\Models\Subscriber;
use App\Models\SubscriptionTier;
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
        $donations = [];
        $subscribers = [];
        $sales = [];

        $donationMessages = [
            fake()->realText(),
            fake()->realText(),
            fake()->realText(),
            fake()->realText(),
            fake()->realText(),
        ];
        $donationMessagesMax = count($donationMessages) - 1;

        $subscriptionTierIds = SubscriptionTier::pluck('id')->toArray();
        $subscriptionTierCount = count($subscriptionTierIds);

        $merchIds = Merchandise::pluck('id')->toArray();
        $merchCount = count($merchIds);

        foreach ($this->famousUserIds as $userId) {
            foreach ($this->userIds as $followerId) {
                if ($userId === $followerId) {
                    continue;
                }

                $followers[] = [
                    'user_id' => $userId,
                    'follower_id' => $followerId,
                    'is_read' => false,
                    'created_at' => Carbon::today()->subDays(random_int(0, 90)),
                ];

                $donations[] = [
                    'user_id' => $userId,
                    'is_read' => false,
                    'created_at' => Carbon::today()->subDays(random_int(0, 90)),
                    'message' => $donationMessages[random_int(0, $donationMessagesMax)],
                    'amount' => random_int(1, 666),
                    'currency' => 'USD',
                ];

                $subscribers[] = [
                    'user_id' => $userId,
                    'is_read' => false,
                    'created_at' => Carbon::today()->subDays(random_int(0, 90)),
                    'subscriber_id' => $followerId,
                    'subscription_tier_id' => $subscriptionTierIds[random_int(0, $subscriptionTierCount - 1)],
                ];

                if($merchCount > 0) {
                    $sales[] = [
                        'user_id' => $userId,
                        'is_read' => false,
                        'created_at' => Carbon::today()->subDays(random_int(0, 90)),
                        'merchandise_id' => $merchIds[random_int(0, $merchCount - 1)],
                        'amount' => random_int(1,30),
                    ];
                }
            }
        }

        foreach (array_chunk($followers, 1000) as $followersChunk) {
            Follower::insert($followersChunk);
        }

        foreach (array_chunk($donations, 1000) as $donationsChunk) {
            Donation::insert($donationsChunk);
        }

        foreach (array_chunk($subscribers, 1000) as $subscriberChunk) {
            Subscriber::insert($subscriberChunk);
        }

        foreach (array_chunk($sales, 1000) as $saleChunk) {
            MerchandiseSale::insert($saleChunk);
        }
    }
}
