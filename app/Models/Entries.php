<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'transaction_id',
        'account_id',
        'amount',
        'entry_type',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class);
    }

    public function account()
    {
        return $this->belongsTo(Accounts::class);
    }
}
