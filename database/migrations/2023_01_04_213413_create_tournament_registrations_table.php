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

            $table->string('tetrio_user_id')->index();
            $table->string('tournament_id')->index();
            $table->boolean('checked_in')->default(false);

            $table->unique(['tetrio_user_id', 'tournament_id']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tournament_registrations');
    }
};
