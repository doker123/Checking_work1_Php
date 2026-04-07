<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScientificPublication extends Model
{
    protected $table = 'Scientific_Publications';
    protected $primaryKey = 'publication_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'edition',
        'publication',
        'index_rsci',
        'team_id',
    ];

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
     * Тип издания (журнал/сборник)
     */
    public function getEditionTypeAttribute(): string
    {
        return $this->edition ?? 'Не указано';
    }

    /**
     * Индексация (РИНЦ/Scopus)
     */
    public function getIndexingAttribute(): string
    {
        return $this->index_rsci ?? 'Не индексировано';
    }
}
