<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionTier extends Model
{
    public $timestamps = false;

    protected $guarded = [
        'id',
    ];
}
