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
        if (!$user->isAdmin()) {
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
}
