<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Card;

class CardType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'account_type'
    ];

    public function cards()
    {
        $this->hasMany(Card::class);
    }
}
