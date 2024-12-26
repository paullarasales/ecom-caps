<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customitem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name', 
        'item_type',
        'item_price',
        'quantity'
    ];

    protected $primaryKey = 'customitem_id';

    public function custompackage()
    {
        return $this->belongsTo(Custompackage::class);
    }
}
