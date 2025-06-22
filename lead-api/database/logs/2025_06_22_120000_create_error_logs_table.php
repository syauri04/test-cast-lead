<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
    {
        Schema::connection('pgsql_logs')->create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->text('error_message');
            $table->string('endpoint');
            $table->integer('status_code');
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
public function down()
    {
        Schema::connection('pgsql_logs')->dropIfExists('error_logs');
    }
}
