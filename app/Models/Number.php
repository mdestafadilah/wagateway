<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','body','webhook','status','messages_sent'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
