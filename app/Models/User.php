<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'city', 'bio', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class, 'investor_id');
    }

    public function sentInvitations()
    {
        return $this->hasMany(CompanyInvitation::class, 'entrepreneur_id');
    }

    public function receivedInvitations()
    {
        return $this->hasMany(CompanyInvitation::class, 'investor_id');
    }

    public function appNotifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    public function isEntrepreneur(): bool
    {
        return $this->role === 'entrepreneur';
    }

    public function isInvestor(): bool
    {
        return $this->role === 'investor';
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return str_starts_with($this->avatar, 'http') ? $this->avatar : \Illuminate\Support\Facades\Storage::url($this->avatar);
        }
        return asset('images/default-avatar.png');
    }
}
