<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blockeddate extends Model
{
    use HasFactory;

    protected $primaryKey = 'blocked_id';

    protected $fillable = [
        'blocked_date',
        'reason',
    ];
}
