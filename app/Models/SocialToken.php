<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialToken extends Model
{
    //
    protected $guarded=[];
    public function user()
    {
        return $this->belongsTo(Token::class, 'user_id');
    }
}
