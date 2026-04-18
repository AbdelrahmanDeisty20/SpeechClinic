<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['first_name', 'last_name', 'phone', 'email', 'password', 'image', 'is_active', 'email_verified_at', 'type'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,HasApiTokens, HasRoles;

    public function isSpecialist(): bool
    {
        return $this->type === 'specialist';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }



    public function fcmTokens()
    {
        return $this->hasMany(UserFcmToken::class);
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/users/' . $this->image);
    }
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getFilamentName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->image ? asset('storage/users/' . $this->image) : null;
    }
    public function refreshTokens()
    {
        return $this->hasMany(RefreshToken::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function appNotifications()
    {
        return $this->hasMany(AppNotification::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(config('filament-shield.super_admin.name', 'super_admin'));
    }
}
