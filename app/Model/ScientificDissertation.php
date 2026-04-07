<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScientificDissertation extends Model
{
    protected $table = 'Scientific_Dissertations';
    protected $primaryKey = 'dissertations_id';
    public $timestamps = false;

    protected $fillable = [
        'theme',
        'approval_date',
        'status_id',
        'scientific_specialy',
        'team_id',
    ];

    /**
     * Статус диссертации
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(StatusDissertation::class, 'status_id', 'status_id');
    }

    /**
     * Команда разработки (аспирант + руководитель)
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(DevelopmentTeam::class, 'team_id', 'team_id');
    }

    /**
     * Аспирант через команду
     */
    public function aspirant()
    {
        return $this->hasOneThrough(
            Aspirant::class,
            DevelopmentTeam::class,
            'team_id',
            'aspirant_id',
            'team_id',
            'aspirant_id'
        );
    }

    /**
     * Научный руководитель через команду
     */
    public function director()
    {
        return $this->hasOneThrough(
            ScientificDirector::class,
            DevelopmentTeam::class,
            'team_id',
            'director_id',
            'team_id',
            'director_id'
        );
    }

    /**
     * Статус текстом (пишется/предзащита/защищена)
     */
    public function getStatusTextAttribute(): string
    {
        return $this->status?->status ?? 'Неизвестно';
    }
}
