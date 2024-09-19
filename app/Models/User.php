<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
        'firstname',
        'lastname',
        'birthday',
        'phone',
        'address',
        'city',
        'photo',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->usertype === 'admin';
    }

    public function isCustomer()
    {
        return $this->usertype === 'user';
    }

    public function package(): HasMany
    {
        return $this->hasMany(Package::class);
    }
    public function faq(): HasMany
    {
        return $this->hasMany(Faqs::class);
    }
    public function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
