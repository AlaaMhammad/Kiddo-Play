<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'sound_enabled' => 'boolean',
        'music_enabled' => 'boolean',
        'extra' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
