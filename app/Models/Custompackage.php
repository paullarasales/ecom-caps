<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custompackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'final_price',
        'person'
    ];

    protected $primaryKey = 'custompackage_id';

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function items()
    {
        return $this->hasMany(Customitem::class, 'custompackage_id');
    }
}
