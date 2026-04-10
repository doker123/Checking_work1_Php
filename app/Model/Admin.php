<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use MvcHelpers\PasswordHasher;

class Admin extends Model implements IdentityInterface
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'login',
        'password',
        'name',
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
        return self::where('id', $id)->first();
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function attemptIdentity(array $credentials)
    {
        $admin = self::where('login', $credentials['login'])->first();

        if ($admin && PasswordHasher::verify($credentials['password'], $admin->password)) {
            return $admin;
        }

        return null;
    }

    public function getUserType(): string
    {
        return 'admin';
    }

    public function getDisplayName(): string
    {
        return trim($this->name ?? '') ?: ($this->login ?? 'Пользователь');
    }
}
