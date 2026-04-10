<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Auth\IdentityInterface;
use MvcHelpers\PasswordHasher;
use MvcHelpers\NameFormatter;

class Aspirant extends Model implements IdentityInterface
{
    protected $table = 'aspirants';
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
        'identity_document',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->password = PasswordHasher::hash($user->password);
        });

        static::updating(function ($user) {
            if ($user->isDirty('password')) {
                $user->password = PasswordHasher::hash($user->password);
            }
        });
    }

    public function findIdentity(int $id)
    {
        return self::where('aspirant_id', $id)->first();
    }

    public function getId(): int
    {
        return (int) $this->aspirant_id;
    }

    public function attemptIdentity(array $credentials)
    {
        $aspirant = self::where('login', $credentials['login'])->first();

        if ($aspirant && PasswordHasher::verify($credentials['password'], $aspirant->password)) {
            return $aspirant;
        }

        return null;
    }

    public function getUserType(): string
    {
        return 'aspirant';
    }

    public function getDisplayName(): string
    {
        return NameFormatter::fullName(
            $this->last_name ?? '',
            $this->name ?? '',
            $this->patronum ?? ''
        );
    }

    public function developmentTeams(): HasMany
    {
        return $this->hasMany(DevelopmentTeam::class, 'aspirant_id', 'aspirant_id');
    }

    public function scientificDirectors(): BelongsToMany
    {
        return $this->belongsToMany(
            ScientificDirector::class,
            'development_team',
            'aspirant_id',
            'director_id'
        );
    }

    public function getFullNameAttribute(): string
    {
        return NameFormatter::fullName(
            $this->last_name ?? '',
            $this->name ?? '',
            $this->patronum ?? ''
        );
    }
}
