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

    public function setPasswordAttribute($value)
    
{
    $this->attributes['password'] = bcrypt($value);
}

    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'id_user');
    }

    protected static function boot()
{
    parent::boot();

    static::created(function ($user) {
        $userProfile = new \App\Models\UserProfile();
        $userProfile->id_user = $user->id_user;
        // Gán các giá trị thông tin bổ sung khác (nếu có)
        $userProfile->save();
    });
}
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'storename',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      
        'password' => 'string',
    ];
}