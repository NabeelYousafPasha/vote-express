<?php

namespace CreatyDev\Domain\Account;

use Illuminate\Database\Eloquent\Model;
use CreatyDev\Domain\Users\Models\User;
class Brand extends Model
{
    protected $fillable = [
        'name' , 
        'desc' ,
        'user_id',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
