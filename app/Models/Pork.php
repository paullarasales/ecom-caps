<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pork extends Model
{
    use HasFactory;
    protected $fillable = ['porkname', 'prokprice'];
    protected $primaryKey = 'pork_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
