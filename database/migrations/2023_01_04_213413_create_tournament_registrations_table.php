<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tournament_registrations', function (Blueprint $table) {
            $table->id();

            $table->string('user_id');
            $table->string('tournament_id');
            $table->boolean('checked_in')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tournament_registrations');
    }
};
