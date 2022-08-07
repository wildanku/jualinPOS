<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['code','type','operator_id','total','discount','tax','grandTotal','payment_method_id','cash_amount','change_amount','product_detail'];

    public $incrementing = false;
    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            do {
                $uuid = Str::uuid()->toString();
            } while (DB::table('pos_transactions')->where('id',$uuid)->exists());

            do {
                $code = Carbon::now()->format('dmy').rand(0000,9999);
            } while (DB::table('pos_transactions')->where('code',$code)->exists());

            $model->id = $uuid;
            $model->code = $code;

        });

    }
    
    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function details()
    {
        return $this->hasMany(PosTransactionDetail::class);
    }

    public function detailJson()
    {
        if($this->product_detail) {
            return json_decode($this->product_detail);
        } 
        return false;
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
