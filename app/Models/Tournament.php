<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;

/**
 * Class Tournament
 * @package App\Models
 *
 * @property-read integer $id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @mixin Model
 */
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
