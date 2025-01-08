<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PHPUnit\Metadata\Before;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'packagename', 
        'packagedesc',
        'discountedprice',
        'packagephoto',
        'packageinclusion',
        'discount',
    ];

    protected $primaryKey = 'package_id';

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class, 'package_id', 'package_id');
    }
    public function custom(): HasMany
    {
        return $this->hasMany(Custom::class);
    }

    public function custompackage(): HasOne
    {
        return $this->hasOne(Custompackage::class, 'package_id');
    }

    public function sample(): HasOne
    {
        return $this->hasOne(Sample::class, 'package_id');
    }

}
