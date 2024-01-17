<?php
// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'name',
        'location',
        'description',
        'date',
        'time',
        'standart_ticket_id',
        'premium_ticket_id',
        'vip_ticket_id',
    ];
}
