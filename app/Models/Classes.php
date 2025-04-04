<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'classes';
    protected $fillable = ['name', 'code', 'description'];

    public function sections()
    {
        return $this->hasMany(Section::class , 'class_id');
    }
}
