<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Custom extends Model
{
    use HasFactory;

    protected $fillable = [
        'veggie', 
        'chicken',
        'pork',
        'beef', 
        'icecream',
        'frenchfries',
        'mixedballs', 
        'hotdogs',
        'cake',
        'lootbags', 
        'setup',
        'final',
    ];

    protected $primaryKey = 'custom_id';

    public function package():BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
