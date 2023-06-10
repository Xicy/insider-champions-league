<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    public function teams(){
        return $this->hasMany(Team::class);
    }

    public function fixtures()
    {
        return $this->hasMany(Week::class);
    }
}
