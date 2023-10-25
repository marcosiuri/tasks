<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tasks;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $fillable = [
        'username',
        'email',
        'password',
        'imagem_perfil_nome',
    ];
    

    protected $table = 'users';

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
