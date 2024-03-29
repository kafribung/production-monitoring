<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Filament Superadmin.
     *
     * @bool>
     */
    public function canAccessFilament(): bool
    {
        // str_ends_with($this->email, '@tigasekawan.com') && $this->hasVerifiedEmail();
        return $this->role == 'super_admin' || $this->role == 'admin' && $this->hasVerifiedEmail();
    }

    /**
     * Filament Avatar.
     *
     * @bool>
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    /**
     * Activated| Field email_verified_at.
     *
     * @bool>
     */
    public function activated()
    {
        $this->email_verified_at ? $this->email_verified_at = null : $this->email_verified_at = now();

        $this->save();
    }

    public function carts()
    {
        return  $this->hasMany(Cart::class, 'created_by');
    }
}
