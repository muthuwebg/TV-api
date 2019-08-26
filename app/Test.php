<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'remember_token',
    ];

    public function hasSubscribed()
    {
    	return $this->hasMany(Order::class)->where('is_active', 1)->count();
    }
}
