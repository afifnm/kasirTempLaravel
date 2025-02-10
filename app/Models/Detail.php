<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'product_id',
        'price',
        'qty'
    ];
    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
