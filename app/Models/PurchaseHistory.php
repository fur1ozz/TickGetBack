<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    protected $table = 'purchase_history';

    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_id',
        'quantity',
    ];

}
