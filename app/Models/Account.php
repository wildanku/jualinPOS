<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name','code','account_type_id','additional_data','isLock','archived_at'];

    public function type()
    {
        return $this->belongsTo(AccountType::class);
    }
}
