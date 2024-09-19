<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faqs extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'answer'];
    protected $primaryKey = 'faq_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
