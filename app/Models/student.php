<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = ['user_id', 'city_id', 'school_id', 'class_id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function city()
    {
        return  $this->belongsTo(city::class);
    }
    public function school()
    {
        return  $this->belongsTo(school::class);
    }
    public function class()
    {
        return  $this->belongsTo(student_class::class);
    }
}
