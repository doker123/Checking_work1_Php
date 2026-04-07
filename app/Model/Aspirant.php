<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aspirant extends Model
{
    protected $table = 'Aspirants';
    protected $primaryKey = 'aspirant_id';
    public $timestamps = false;

    protected $fillable = [
        'login',
        'password',
        'name',
        'patronum',
        'last_name',
        'date_of_birth',
        'gender',
        'citizenship',
        'identity document',
    ];

    protected $hidden = [
        'password',
    ];


    public function developmentTeams(): HasMany
    {
        return $this->hasMany(DevelopmentTeam::class, 'aspirant_id', 'aspirant_id');
    }


    public function scientificDirectors(): BelongsToMany
    {
        return $this->belongsToMany(
            ScientificDirector::class,
            'Development_Team',
            'aspirant_id',
            'director_id'
        );
    }


    public function dissertations(): HasMany
    {
        return $this->hasMany(ScientificDissertation::class, 'aspirant_id', 'aspirant_id');
    }


    public function publications(): HasMany
    {
        return $this->hasMany(ScientificPublication::class, 'aspirant_id', 'aspirant_id');
    }


    public function getFullNameAttribute(): string
    {
        return "{$this->last_name} {$this->name} {$this->patronum}";
    }
}
