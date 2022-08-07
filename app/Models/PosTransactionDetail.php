<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosTransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = ['pos_transaction_id','product_id','custom_product_name','product_name','custom_product_id','amount','price','total'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {

            // update product stock. 
            // in this case, stock type always out.
            if($model->product_id) {
                if($model->product->is_tracked) {
                    $lastStock = $model->product->latest_stock();
                    $amount = $model->amount;
                    $newStock = $lastStock - $amount;

                    ProductStockHistory::create([
                        'product_id' => $model->product_id,
                        'type' => 'out',
                        'amount' => $amount,
                        'current_stock' => $newStock
                    ]);
                }
            }
        });

    }

    public function pos_transaction()
    {
        return $this->belongsTo(PosTransaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function custom_product()
    {
        return $this->belongsTo(CustomProduct::class);
    }
}
