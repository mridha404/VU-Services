<?php

// app/Models/TransactionHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TransactionHistory extends Model
{
    use HasFactory;

    protected $table = 'transactionhistory';
    protected $fillable = ['service_id', 'transaction_id', 'quantity', 'total_amount'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
