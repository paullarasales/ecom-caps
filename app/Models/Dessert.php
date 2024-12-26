<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dessert extends Model
{
    use HasFactory;

    protected $fillable = [
        'dessertname',
        'dessertprice'
    ];
    protected $primaryKey = 'dessert_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
