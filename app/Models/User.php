<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends Authenticatable implements MustVerifyEmail
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
        'verifyisread', 
        'submitisread'
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

    public function isManager()
    {
        return $this->usertype === 'manager';
    }

    public function isOwner()
    {
        return $this->usertype === 'owner';
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
    public function custom(): HasMany
    {
        return $this->hasMany(Custom::class);
    }

    public function food(): HasMany
    {
        return $this->hasMany(Food::class);
    }
    public function foodcart(): HasMany
    {
        return $this->hasMany(Foodcart::class);
    }
    public function foodpack(): HasMany
    {
        return $this->hasMany(Foodpack::class);
    }
    public function lechon(): HasMany
    {
        return $this->hasMany(Lechon::class);
    }
    public function cake(): HasMany
    {
        return $this->hasMany(Cake::class);
    }
    public function clown(): HasMany
    {
        return $this->hasMany(Clown::class);
    }
    public function setup(): HasMany
    {
        return $this->hasMany(Setup::class);
    }
    public function facepaint(): HasMany
    {
        return $this->hasMany(Facepaint::class);
    }
    public function beef(): HasMany
    {
        return $this->hasMany(Beef::class);
    }
    public function pork(): HasMany
    {
        return $this->hasMany(Pork::class);
    }
    public function chicken(): HasMany
    {
        return $this->hasMany(Chicken::class);
    }
    public function veggie(): HasMany
    {
        return $this->hasMany(Veggie::class);
    }
    public function other(): HasMany
    {
        return $this->hasMany(Others::class);
    }
    public function dessert(): HasMany
    {
        return $this->hasMany(Dessert::class);
    }

    public function dish(): HasMany
    {
        return $this->hasMany(Dish::class);
    }
    public function log(): HasMany
    {
        return $this->hasMany(Log::class);
    }
}
