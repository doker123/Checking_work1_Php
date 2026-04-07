<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusDissertation extends Model
{
    protected $table = 'Status_Dissertations';
    protected $primaryKey = 'status_id';
    public $timestamps = false;

    protected $fillable = [
        'status',
    ];

    public function dissertations(): HasMany
    {
        return $this->hasMany(ScientificDissertation::class, 'status_id', 'status_id');
    }
}
