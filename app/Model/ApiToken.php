<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiToken extends Model
{
    protected $table = 'api_tokens';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_type',
        'token',
        'expires_at',
        'created_at',
    ];

    /**
     * Проверка срока действия токена
     */
    public function isExpired(): bool
    {
        if ($this->expires_at === null) {
            return false;
        }
        return strtotime($this->expires_at) < time();
    }

    /**
     * Связь с аспирантом
     */
    public function aspirant(): BelongsTo
    {
        return $this->belongsTo(Aspirant::class, 'user_id', 'aspirant_id');
    }

    /**
     * Связь с научным руководителем
     */
    public function director(): BelongsTo
    {
        return $this->belongsTo(ScientificDirector::class, 'user_id', 'director_id');
    }
}
