<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;
    protected $fillable = ['section_name', 'section_desc', 'Created_by'];


    public function products()
    {
        $this->hasMany(Products::class);
    }
}
