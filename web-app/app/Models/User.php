<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a student (mahasiswa).
     */
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    /**
     * Get the cafes favorited by this user.
     */
    public function favorites()
    {
        return $this->belongsToMany(KafeModel::class, 'favorit_kafe', 'user_id', 'kafe_id');
    }

    /**
     * Get the reviews written by this user.
     */
    public function reviews()
    {
        return $this->hasMany(ReviewModel::class, 'user_id');
    }

    /**
     * Get the cafes proposed/submitted by this user.
     */
    public function proposedCafes()
    {
        return $this->hasMany(KafeModel::class, 'user_id', 'id');
    }

    /**
     * Get the cafes blacklisted by this user.
     */
    public function blacklistedCafes()
    {
        return $this->belongsToMany(KafeModel::class, 'blacklist_kafe', 'user_id', 'kafe_id');
    }
}
