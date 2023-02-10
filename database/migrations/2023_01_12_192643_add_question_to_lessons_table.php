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
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('question')->after('lesson_content')->nullable();
            $table->string('answer')->after('question')->nullable();
            $table->string('choice1')->after('answer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('question');
            $table->dropColumn('answer');
            $table->dropColumn('choice1');
            $table->dropColumn('choice2');
        });
    }
};
