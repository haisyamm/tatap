<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RABDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_rab' ,
        'id_product' ,
        'price' ,
        'qty' ,
        'sub_total' ,
    ];
    public function getProduct(){
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
    
}
