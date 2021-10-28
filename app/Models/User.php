<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool {
        return $this->is_admin;
    }

    public function sites() {
        return $this->hasMany(Site::class);
    }

    public function getSSHKeysDir(): string {
        if(!is_dir(config('larahost.keys_dir'))){
            mkdir(config('larahost.keys_dir'));
        }
        $user_keys = config('larahost.keys_dir') . '/' . $this->email;
        if(!is_dir($user_keys)){
            mkdir($user_keys);
        }
        return $user_keys;
    }
}
