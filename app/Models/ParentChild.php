<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentChild extends Model
{
    use HasFactory;
    protected $table = 'parent_children'; // ← مهم جداً
    protected $fillable = ['parent_id', 'kid_id'];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function kid()
    {
        return $this->belongsTo(Kid::class, 'kid_id');
    }
}
