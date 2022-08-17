<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'sender', 'name', 'tag', 'type', 'status', 'message', 'schedule'];

    public function blasts(){
        return $this->hasMany(Blast::class);
    }
}
