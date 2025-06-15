<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'status',
        'email_verified_at',
        'reset_password_token',
        'reset_password_expires_at',
        'role_id',
        'address',
        'avatar',
        'remember_token',
        'verification_code',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'reset_password_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'reset_password_expires_at' => 'datetime',
            'status' => 'string',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}