<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Site extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted() {
        $user = Auth::user();
        if ($user && !$user->isAdmin()) {
            static::addGlobalScope('user_id', function (Builder $builder) use($user) {
                $builder->where('user_id', $user->id);
            });
        }
    }

    public function getRouteKeyName() {
        return 'name';
    }

    public function domains(){
        return $this->hasMany(Domain::class);
    }

    public function getProjectBaseDir() {
        if (empty(config('larahost.repos_dir')))
            throw new \Exception('Repos dir is not defined');

        return config('larahost.repos_dir') . '/' . $this->user->email . '/' .$this->name;
    }

    public function getDockerComposeDir() {
        return $this->getProjectBaseDir() . '/' . config('larahost.dir_names.docker-compose');
    }

    public function getSourceDir() {
        return $this->getProjectBaseDir() . '/' . config('larahost.dir_names.source');
    }

    public function getDeploymentLogsDir() {
        return $this->getProjectBaseDir() . '/' . config('larahost.dir_names.deployment_logs');
    }

    public function getLaravelLogsDir() {
        return $this->getSourceDir() . '/' . config('larahost.dir_names.laravel_logs');
    }

    public function getWorkersDir() {
        return $this->getProjectBaseDir() . '/' . config('larahost.dir_names.workers');
    }
}
