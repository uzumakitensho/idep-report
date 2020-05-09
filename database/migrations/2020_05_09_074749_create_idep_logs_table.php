<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdepLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idep_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_idep_log');
            $table->unsignedBigInteger('employee_id')->index();
            $table->dateTime('transaction_at', 2);
            $table->bigInteger('value');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('idep_logs');
    }
}
