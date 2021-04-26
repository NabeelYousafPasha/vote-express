<?php

namespace CreatyDev\Domain\Account;

use Illuminate\Database\Eloquent\Model;
use CreatyDev\Domain\Account\Contestant;
use CreatyDev\Domain\Users\Models\User;

class Contest extends Model
{
    protected $table="contest";

    protected $fillable = [
    	    'title' , 
            'user_id' ,
            'street_address'  ,
            'city',
            'zip_code' ,
            'country' ,
            'desc'  ,
            'contest_type',
            'vote_amount',
            'vote_count',
            'votetopercent',
            'contest_currency',
            'start_date',
            'end_date' ,
            'status' ,
    ];

    public function contestants()
    {
        return $this->hasMany(Contestant::class, 'contest_id','id')->orderBy('votes','DESC');
    }

    public function topfivecontestants()
    {
        return $this->hasMany(Contestant::class, 'contest_id','id')->orderBy('votes','DESC')->limit(5);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
