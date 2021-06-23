<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
