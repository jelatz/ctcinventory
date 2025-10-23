<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{

    use HasFactory, Notifiable;

    protected $fillable = [
        "name",
        "description",
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role')->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission')->withTimestamps();
    }
}
