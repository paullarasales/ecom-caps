<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lechon extends Model
{
    use HasFactory;

    protected $fillable = [
        'lechonname',
        'lechonprice'
    ];
    protected $primaryKey = 'lechon_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
