<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Foodcart extends Model
{
    use HasFactory;

    protected $fillable = [
        'foodcartname',
        'foodcartprice'
    ];
    protected $primaryKey = 'foodcart_id';


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
