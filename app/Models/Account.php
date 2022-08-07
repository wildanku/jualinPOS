<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['name','code','account_type','additional_data','isLock','archived_at'];

    public function type()
    {
        return $this->belongsTo(AccountType::class);
    }
}
