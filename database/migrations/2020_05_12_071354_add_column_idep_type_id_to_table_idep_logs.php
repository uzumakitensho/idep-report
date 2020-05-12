<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIdepTypeIdToTableIdepLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('idep_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('idep_type_id')->index()->nullable()->after('uuid_idep_log');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('idep_logs', function (Blueprint $table) {
            $table->dropIndex(['idep_type_id']);
            $table->dropColumn('idep_type_id');
        });
    }
}
