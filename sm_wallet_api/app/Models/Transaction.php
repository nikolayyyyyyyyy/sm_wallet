<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'amount',
        'note',
        'transaction_type_id',
        'account_sender_id',
        'account_receiver_id'
    ];
}
