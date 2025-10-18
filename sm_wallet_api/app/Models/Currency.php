<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Card;

class Currency extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'currency'
    ];

    public function cards()
    {
        $this->hasMany(Card::class);
    }
}
