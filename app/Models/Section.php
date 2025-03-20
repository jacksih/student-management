<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';
    protected $fillable = ['class_id', 'name'];

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
