<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = ['name', 'email', 'class_id', 'section_id'];

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function sections()
    {
        return $this->belongsTo(Section::class);
    }
}
