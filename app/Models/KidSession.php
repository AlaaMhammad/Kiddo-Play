<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KidSession extends Model
{
    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'activity' => 'array'
    ];

    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }
}
