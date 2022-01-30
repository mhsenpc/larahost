<?php

namespace App\Models;

use App\Notifications\RegisterNotification;
use App\Services\SuperUserAPIService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;

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
            SuperUserAPIService::new_folder(config('larahost.keys_dir'));
        }
        $user_keys = config('larahost.keys_dir') . '/' . $this->email;
        if(!is_dir($user_keys)){
            SuperUserAPIService::new_folder($user_keys);
        }
        return $user_keys;
    }

    protected static function booted() {
        static::created(function ($user) {
            $user->generateKeyPair();
            Notification::send($user,new RegisterNotification($user));
        });
    }

    public function generateKeyPair(){
        // generate key pair
        SuperUserAPIService::generate_key_pair($this->email, $this->getSSHKeysDir());

        //disable strict host checking
        $config = "Host *
    StrictHostKeyChecking no";
        SuperUserAPIService::put_contents("{$this->getSSHKeysDir()}/config", $config);

    }
}
