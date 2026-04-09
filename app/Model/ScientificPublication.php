<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScientificPublication extends Model
{
    protected $table = 'scientific_publications';
    protected $primaryKey = 'publication_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'edition',
        'publication',
        'index_rsci',
        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(DevelopmentTeam::class, 'team_id', 'team_id');
    }

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

    public function getEditionTypeAttribute(): string
    {
        return $this->edition ?? 'Не указано';
    }

    public function getIndexingAttribute(): string
    {
        return $this->index_rsci ?? 'Не индексировано';
    }
}
