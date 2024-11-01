<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Metadata\Before;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'packagename', 
        'packagedesc',
        'packagephoto',
    ];

    protected $primaryKey = 'package_id';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    public function custom(): HasMany
    {
        return $this->hasMany(Custom::class);
    }

    public function custompackage(): HasMany
    {
        return $this->hasMany(Custompackage::class, 'package_id');
    }

}
