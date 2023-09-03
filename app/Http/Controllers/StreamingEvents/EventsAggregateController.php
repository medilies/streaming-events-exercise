<?php

namespace App\Http\Controllers\StreamingEvents;

use App\Models\Donation;
use App\Models\Follower;
use App\Models\MerchandiseSale;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventsAggregateController
{
    public function __invoke(Request $request)
    {
        // ? use CONCAT to serialize JSON and let frontend formulate the message
        return DB::table(
            Follower::select('followers.id', 'followers.created_at', 'is_read')
                ->selectRaw("'followers' AS streaming_event_type")
                ->selectRaw("CONCAT(users.name, ' followed you!') AS streaming_event_text")
                ->join('users', 'users.id', '=', 'followers.user_id')
                ->union(Subscriber::select('subscribers.id', 'subscribers.created_at', 'is_read')
                    ->selectRaw("'subscribers' AS streaming_event_type")
                    ->selectRaw("CONCAT(users.name, ' (', subscription_tiers.name, ') subscribed to you!') AS streaming_event_text")
                    ->join('subscription_tiers', 'subscription_tiers.id', '=', 'subscribers.subscription_tier_id')
                    ->join('users', 'users.id', '=', 'subscribers.subscriber_id')
                )
                ->union(Donation::select('donations.id', 'donations.created_at', 'is_read')
                    ->selectRaw("'donations' AS streaming_event_type")
                    ->selectRaw("CONCAT(users.name, ' donated ', donations.amount, ' ', donations.currency, ' to you! “', donations.message, ' ”') AS streaming_event_text")
                    ->join('users', 'users.id', '=', 'donations.donator_id')
                )
                ->union(MerchandiseSale::select('merchandise_sales.id', 'merchandise_sales.created_at', 'is_read')
                    ->selectRaw("'merchandise_sales' AS streaming_event_type")
                    ->selectRaw("CONCAT(users.name, ' bought some ', merchandises.name, ' from you for ', merchandises.price, ' ', merchandises.currency, '!') AS streaming_event_text")
                    ->join('users', 'users.id', '=', 'merchandise_sales.buyer_id')
                    ->join('merchandises', 'merchandises.id', '=', 'merchandise_sales.merchandise_id')
                ),
            'aggregate'
        )
            ->orderBy('created_at')
            ->paginate(
                perPage: 100,
                page: $request->get('page')
            );
    }
}
