<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use MvcHelpers\PasswordHasher;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'login',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function attemptIdentity(array $credentials)
    {
        $user = self::where('login', $credentials['login'])->first();

        if ($user && PasswordHasher::verify($credentials['password'], $user->password)) {
            return $user;
        }

        return null;
    }


    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }


    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }


    public function isResearcher(): bool
    {
        return $this->hasRole('researcher');
    }

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
}
