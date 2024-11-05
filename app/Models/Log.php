<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'description'
    ];
    protected $primaryKey = 'log_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
