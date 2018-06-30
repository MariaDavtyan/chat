<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function chat()
    {
        return $this->belongsTo('App\Models\Chat');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
