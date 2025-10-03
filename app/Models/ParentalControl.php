<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentalControl extends Model
{
    protected $guarded = [];

    protected $casts = [
        'rules' => 'array',
        'purchases_enabled' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }
}
