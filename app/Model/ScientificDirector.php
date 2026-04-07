<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScientificDirector extends Model
{
    protected $table = 'Scientific_Director';
    protected $primaryKey = 'director_id';
    public $timestamps = false;

    protected $fillable = [
        'login',
        'password',
        'name',
        'patronum',
        'lasr_name',
        'date_of_birth',
        'gender',
        'citizenship',
        'academic_degree',
        'title_id',
    ];

    protected $hidden = [
        'password',
    ];


    public function academicTitle(): BelongsTo
    {
        return $this->belongsTo(AcademicTitle::class, 'title_id', 'title_id');
    }


    public function developmentTeams(): HasMany
    {
        return $this->hasMany(DevelopmentTeam::class, 'director_id', 'director_id');
    }


    public function aspirants(): BelongsToMany
    {
        return $this->belongsToMany(
            Aspirant::class,
            'Development_Team',
            'director_id',
            'aspirant_id'
        );
    }


    public function dissertations(): HasMany
    {
        return $this->hasMany(ScientificDissertation::class, 'director_id', 'director_id');
    }


    public function getFullNameAttribute(): string
    {
        return "{$this->lasr_name} {$this->name} {$this->patronum}";
    }
}
