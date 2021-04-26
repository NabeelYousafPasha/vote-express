<?php

namespace CreatyDev\Domain\Messages;

use Illuminate\Database\Eloquent\Model;
use CreatyDev\Domain\Users\Models\User;
class Message extends Model
{
    protected $table="messages";
    protected $fillable = [
        'receiver' , 
        'sender' ,
        'subject',
        'message',
    ];

    
}
