<?php

// database/migrations/xxxx_xx_xx_add_columns_to_students_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;





class AddColumnsToStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('rollnumber')->nullable();
            $table->string('mobile_number')->nullable();
            $table->foreignId('department_id')->constrained('departments');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('rollnumber');
            $table->dropColumn('mobile_number');
            $table->dropForeign(['department_id']);
            $table->dropColumn('department_id');
        });
    }
}
