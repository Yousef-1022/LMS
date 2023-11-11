<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $fillable = ["name", "description", "points"];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class);
    }
}
