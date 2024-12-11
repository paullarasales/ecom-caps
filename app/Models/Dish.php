<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dish extends Model
{
    use HasFactory;
    protected $fillable = [
        'dishname', 
        'dishphoto',
        'dishcategory',
    ];
    protected $primaryKey = 'dish_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
