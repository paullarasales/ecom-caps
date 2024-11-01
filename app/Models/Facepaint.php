<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facepaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'facepaintname',
        'facepaintprice'
    ];
    protected $primaryKey = 'facepaint_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
