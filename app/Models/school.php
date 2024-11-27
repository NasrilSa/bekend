<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class school extends Model
{
    protected  $table = 'schools';
    protected $fillable = ['name', 'city_id'];

    public function city()
    {
        return $this->belongsTo(city::class);
    }
    public function student_class()
    {
        return $this->hasMany(student_class::class);
    }
    // public function student()
    // {
    //     return $this->hasMany(student::class);
    // }
}
