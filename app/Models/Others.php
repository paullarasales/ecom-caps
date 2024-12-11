<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Others extends Model
{
    use HasFactory;
    protected $fillable = ['othername', 'otherprice'];
    protected $primaryKey = 'other_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
