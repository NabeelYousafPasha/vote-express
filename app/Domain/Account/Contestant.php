<?php

namespace CreatyDev\Domain\Account;

use Illuminate\Database\Eloquent\Model;
use CreatyDev\Domain\Account\Contest;

class Contestant extends Model
{
    protected $table="contestants";
    protected $fillable = [
        'name' , 
        'email' ,
        'phone',
        'contest_id',
        'votes',
        'avatar',
    ];

    public function contestt()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }
}
