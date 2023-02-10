<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_user', function (Blueprint $table) {
            $table->longText('paragraph')->after('quiz_mark')->nullable();
            $table->string('evaluation')->after('paragraph')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_user', function (Blueprint $table) {
            $table->dropColumn('paragraph');
            $table->dropColumn('evaluation');
        });
    }
};
