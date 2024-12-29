<?php

// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // Relation many-to-many avec User
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
