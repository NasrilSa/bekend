<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student_class extends Model
{
    protected $table = 'student_classes';
    protected $guarded = ["id"];

    public function school()
    {
        return $this->belongsTo(school::class);
    }
    public function student()
    {
        return $this->hasMany(student::class, 'class_id');
    }
}
