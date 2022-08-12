<?php

namespace App\Models;

use App\Services\TaxService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','sku','photo','is_tracked','tax_type','tax_id'];

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function buy_prices()
    {
        return $this->prices->count() > 0 ? $this->prices->where('type','buy_price') : null;
    }

    public function buy_price()
    {
        $price = ProductPrice::where('type','buy_price')->where('product_id',$this->id)->latest()->first();

        if($price) {
            return $price->price;
        } else {
            return false;
        }
    }

    public function sell_prices()
    {
        return $this->prices->count() > 0 ? $this->prices->where('type','sell_price') : null;
    }

    public function sell_price()
    {
        $price = ProductPrice::where('type','sell_price')->where('product_id',$this->id)->latest()->first();

        if($price) {
            return $price->price;
        } else {
            return false;
        }
    }

    public function sell_price_after_tax()
    {
        $taxService = new TaxService();
        if($this->tax && $this->tax_type == "include") {
            return $taxService->countIncludeTax($this->sell_price(), $this->tax->percent)['total'];
        } else {
            return $this->sell_price();
        }
    }

    public function countTax()
    {
        $taxService = new TaxService();
        if($this->tax && $this->tax_type == "include") {
            return $taxService->countIncludeTax($this->sell_price(), $this->tax->percent)['tax'];
        } else {
            return $taxService->countExcludeTax($this->sell_price(), $this->tax->percent);
        }
    }

    public function stock_histories()
    {
        return $this->hasMany(ProductStockHistory::class);
    }

    public function latest_stock()
    {
        if($this->is_tracked) {
            $stock = ProductStockHistory::where('product_id',$this->id)->latest()->first();

            if($stock) {
                return $stock->current_stock ?? '';
            } 
        }

        return false;
    }

    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }

    public function getCart()
    {
        $user = Auth::user();
        $userCart = Cart::where(['product_id' => $this->id, 'user_id' => $user->id])->first();
        return $userCart ? $userCart->amount ?? 0 : 0;
    }

    public function pos_transactions()
    {
        return $this->hasMany(PosTransactionDetail::class);
    }

    
}
