<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setup extends Model
{
    use HasFactory;

    protected $fillable = [
        'setupname',
        'setupprice'
    ];
    protected $primaryKey = 'setup_id';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
