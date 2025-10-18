<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CardType;
use App\Models\Currency;

class Card extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'card_number',
        'amount',
        'interest',
        'currency_id',
        'card_type_id',
        'user_id'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function currency()
    {
        $this->belongsTo(Currency::class);
    }

    public function card_type()
    {
        $this->belongsTo(CardType::class);
    }
}
