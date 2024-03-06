<?php

// app/Models/Student.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Student extends Model
{
    use HasFactory;

 
    protected $fillable = ['name', 'email', 'balance', 'rollnumber', 'mobile_number', 'department_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function transactionHistory()
    {
        return $this->hasManyThrough(TransactionHistory::class, Transaction::class);
    }
}
