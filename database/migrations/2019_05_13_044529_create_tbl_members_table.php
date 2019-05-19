<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique()->comment('name member');
            $table->text('infomation')->nullable()->comment('infomation');
            $table->string('phone', 20)->unique()->comment('phone number');
            $table->date('date_of_birth')->comment('date of birth');
            $table->string('avatar')->nullable()->comment('avatar');
            $table->string('position')->comment('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_members');
    }
}
