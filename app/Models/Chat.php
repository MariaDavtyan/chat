<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'id', 'name', 'image', 'access', 'private_chat'
    ];

    public function message()
    {
        return $this->hasMany('App\Models\Message');
    }
}
