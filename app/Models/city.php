<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class city extends Model

{
    use HasFactory;
    protected $table = 'cities';
    protected $guarded = ['id'];

    public function School()
    {
        return $this->hasMany(school::class);
    }
    public function student()
    {
        return $this->hasMany(student::class);
    }
}
