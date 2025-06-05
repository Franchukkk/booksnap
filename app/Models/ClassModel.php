<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'classes';

    protected $fillable = [
        'school_id',
        'name',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id')
                    ->where('role', 'student')
                    ->withTimestamps();
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_user', 'user_id', 'class_id')
                    ->withTimestamps();
    }


}
