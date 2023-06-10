<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 * @package App\Models
 *
 * @property-read integer $id
 * @property string $name
 * @property int $power
 * @property int $points
 * @property int $won,
 * @property int $drawn,
 * @property int $lost,
 * @property int $goals_for,
 * @property int $goals_against,
 * @property int $goal-difference,
 * @property Tournament $tournament
 *
 * @mixin Model
 */
class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'power',
        'points',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
    ];

    public $timestamps = false;

    protected $appends = ['goal_difference'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function goalDifference(): Attribute
    {
        return new Attribute(get: fn () => $this->goals_for - $this->goals_against);
    }
}
