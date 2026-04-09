<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Auth\IdentityInterface;

class ScientificDirector extends Model implements IdentityInterface
{
    protected $table = 'scientific_director';
    protected $primaryKey = 'director_id';
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
        'academic_degree',
        'title_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function findIdentity(int $id)
    {
        return self::where('director_id', $id)->first();
    }

    public function getId(): int
    {
        return (int) $this->director_id;
    }

    public function attemptIdentity(array $credentials)
    {
        $director = self::where('login', $credentials['login'])->first();

        if ($director && password_verify($credentials['password'], $director->password)) {
            return $director;
        }

        return null;
    }

    public function getUserType(): string
    {
        return 'director';
    }

    public function getDisplayName(): string
    {
        return "{$this->last_name} {$this->name} {$this->patronum}";
    }

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
            'development_team',
            'director_id',
            'aspirant_id'
        );
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->last_name} {$this->name} {$this->patronum}";
    }
}
