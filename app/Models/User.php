<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id_user';

    protected $table = 'users';

    protected $guarded = ['id_user'];

    protected $fillables = ['name', 'email', 'password', 'location_id', 'role_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the location associated with the user.
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'id_user');
    }

    /**
     * Get the role associated with the user.
     */

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'id_user');
    }

    /**
     * Get the tasks associated with the user.
     */

     public function task(): HasOne
     {
         return $this->hasOne(Task::class, 'id', 'id_user');
     }
}
