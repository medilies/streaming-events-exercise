<?php

namespace App\Http\Controllers\StreamingEvents;

use App\Models\Donation;
use App\Models\MerchandiseSale;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController
{
    public function __invoke(Request $request)
    {
        $date = Carbon::now()->subDays(30);

        return DB::table(
            Subscriber::selectRaw('SUM(amount) AS revenue')
                ->join('subscription_tiers', 'subscription_tiers.id', '=', 'subscribers.subscription_tier_id')
                ->where('created_at', '>=', $date)
                ->union(Donation::selectRaw('SUM(amount) AS revenue')
                    ->where('created_at', '>=', $date)
                )
                ->union(MerchandiseSale::selectRaw('SUM(price*amount) AS revenue')
                    ->join('merchandises', 'merchandises.id', '=', 'merchandise_sales.merchandise_id')
                    ->where('created_at', '>=', $date)
                ),
            'aggregate'
        )
            ->selectRaw('SUM(revenue) as revenue')
            ->get();
    }
}
