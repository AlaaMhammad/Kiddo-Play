<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $guarded = [];

    public function kids()
    {
        return $this->hasMany(Kid::class);
    }
}
