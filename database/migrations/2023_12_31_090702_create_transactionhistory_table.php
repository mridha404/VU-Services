<?php

// database/migrations/xxxx_xx_xx_create_transactionhistory_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionhistoryTable extends Migration
{
    public function up()
    {
        Schema::create('transactionhistory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('transaction_id');
            $table->integer('quantity');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactionhistory');
    }
}
