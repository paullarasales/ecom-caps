<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chicken extends Model
{
    use HasFactory;
    protected $fillable = ['chickenname', 'chickenprice'];
    protected $primaryKey = 'chicken_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
