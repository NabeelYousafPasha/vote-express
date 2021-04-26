<?php

namespace CreatyDev\Domain\Subscriptions\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    // public function __construct(array $attributes = [])
    // {
        // parent::__construct($attributes);
        // dd($attributes);
    // }
    //use Sluggable;
    protected $table='subscriptions';

    protected $fillable = [
        'name',
        'user_id',
        'stripe_id',
        'stripe_plan',
        'quantity',
        'trial_ends_at',
        'ends_at'
    ];

    
}
