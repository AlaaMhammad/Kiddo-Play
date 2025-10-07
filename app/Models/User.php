<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'meta' => 'array',
            'password' => 'hashed',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function kid()
    {
        return $this->hasOne(Kid::class);
    }

    public function userSetting()
    {
        return $this->hasOne(UserSetting::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }

    public function parentalControls()
    {
        return $this->hasMany(ParentalControl::class, 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany(Kid::class, 'parent_children', 'parent_id', 'kid_id');
    }
}
