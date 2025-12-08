<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Account;
use App\Models\Favorite;

class User extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'role_id'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function cards()
    {
        return $this->hasMany(Account::class, 'user_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

}
