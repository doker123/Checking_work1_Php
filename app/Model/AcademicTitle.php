<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicTitle extends Model
{
    protected $table = 'Academic_Title';
    protected $primaryKey = 'title_id';
    public $timestamps = false;

    protected $fillable = [
        'academic_title',
    ];

    public function scientificDirectors(): HasMany
    {
        return $this->hasMany(ScientificDirector::class, 'title_id', 'title_id');
    }
}
