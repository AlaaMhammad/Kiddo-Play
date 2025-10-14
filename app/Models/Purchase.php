<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'details' => 'array',
    ];

    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }

    public function storeItem()
    {
        return $this->belongsTo(StoreItem::class);
    }
}
