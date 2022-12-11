<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['status']);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
