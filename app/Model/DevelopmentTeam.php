<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DevelopmentTeam extends Model
{
    protected $table = 'Development_Team';
    protected $primaryKey = 'team_id';
    public $timestamps = false;

    protected $fillable = [
        'director_id',
        'aspirant_id',
    ];

    /**
     * Научный руководитель команды
     */
    public function director(): BelongsTo
    {
        return $this->belongsTo(ScientificDirector::class, 'director_id', 'director_id');
    }

    /**
     * Аспирант команды
     */
    public function aspirant(): BelongsTo
    {
        return $this->belongsTo(Aspirant::class, 'aspirant_id', 'aspirant_id');
    }

    /**
     * Диссертации команды
     */
    public function dissertations(): HasMany
    {
        return $this->hasMany(ScientificDissertation::class, 'team_id', 'team_id');
    }

    /**
     * Публикации команды
     */
    public function publications(): HasMany
    {
        return $this->hasMany(ScientificPublication::class, 'team_id', 'team_id');
    }
}
