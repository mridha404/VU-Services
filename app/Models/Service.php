<?php

// app/Models/Service.php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Service extends Model
{
    use HasFactory;

    protected $fillable = ['servicename', 'servicedescription', 'price'];

    public function transactionHistory()
    {
        return $this->hasMany(TransactionHistory::class);
    }
}


