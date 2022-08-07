<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','price','product_id','custom_product_id','amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customProduct()
    {
        return $this->belongsTo(CustomProduct::class);
    }

    public function getProduct()
    {
        // if()
    }
}
