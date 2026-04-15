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

#[Fillable(['first_name', 'last_name', 'phone', 'age', 'gender_id', 'nationality_id', 'email', 'password', 'image', 'is_active', 'email_verified_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,HasApiTokens, HasRoles;

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

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
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

    public function canAccessPanel(Panel $panel): bool
    {
        return true; // For now, allowing all users to access the panel. You can add role checks here later.
    }
}
