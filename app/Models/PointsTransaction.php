<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];

    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }
}
