<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
