<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    use HasFactory;
    //public $fillable = ["name","description","code","credit","image_url","teacher_id"];
    public $fillable = ["name","description","code","credit","image_url"];

    public function tasks() {
        return $this->hasMany(Task::class);
    }
//
    //public function user()
    //{
    //    return $this->belongsTo(User::class);
    //}
    public function teacher() {
        return $this->belongsTo(User::class);
    }
    public function students() {
        return $this->belongsToMany(User::class);
    }
}
