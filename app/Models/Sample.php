<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected $fillable = ['samplepath'];
    protected $casts = [
        'samplepath' => 'array',
    ];
    protected $primaryKey = 'sample_id';

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

}
