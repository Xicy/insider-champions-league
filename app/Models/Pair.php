<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pair
 * @package App\Models
 *
 * @property-read integer $id
 * @property integer $week
 * @property integer $home_team_id
 * @property integer $away_team_id
 * @property integer $home_team_score
 * @property integer $away_team_score
 * @property integer $played
 *
 * @mixin Model
 */
class Pair extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'week',
        'home_team_id',
        'away_team_id',
        'home_team_score',
        'away_team_score',
        'played'
    ];

    public $timestamps = false;

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
