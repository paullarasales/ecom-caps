<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Clown extends Model
{
    use HasFactory;

    protected $fillable = [
        'clownname',
        'clownprice'
    ];
    protected $primaryKey = 'clown_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
