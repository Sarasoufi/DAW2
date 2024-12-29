<?php
        
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'title', 'description', 'status', 'keywords',
    'technologies'];

    /**
     * Relation avec l'enseignant (User)
     * Chaque projet appartient à un enseignant (Teacher).
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Relation avec les candidatures (Applications)
     * Chaque projet peut avoir plusieurs candidatures.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}

