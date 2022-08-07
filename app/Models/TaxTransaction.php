<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['tax_id','transaction_id','hasModelRelation','relation_id','amount','is_reconcile'];
    
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
