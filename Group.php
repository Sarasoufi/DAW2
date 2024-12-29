<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {
    protected $table = 'Group';
    use HasFactory;

    protected $fillable = ['name'];

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function applications() {
        return $this->hasMany(Application::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class);
    }
}