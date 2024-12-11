<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Veggie extends Model
{
    use HasFactory;
    protected $fillable = ['veggiename', 'veggieprice'];
    protected $primaryKey = 'veggie_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
