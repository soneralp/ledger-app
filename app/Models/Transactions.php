<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'transaction_type',
        'amount',
        'description',
        'transaction_date',
    ];

    public function account()
    {
        return $this->belongsTo(Accounts::class);
    }

    public function entries()
    {
        return $this->hasMany(Entries::class);
    }
}
