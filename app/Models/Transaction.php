<?php

// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = ['student_id', 'date', 'amount', 'payment_method', 'transaction_type', 'status'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function transactionHistory()
    {
        return $this->hasMany(TransactionHistory::class);
    }
}



