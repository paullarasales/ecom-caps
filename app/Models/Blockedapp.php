<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blockedapp extends Model
{
    use HasFactory;

    protected $primaryKey = 'blockedapp_id';

    protected $fillable = [
        'blocked_app',
        'appreason',
    ];
}
