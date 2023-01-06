<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tetrio_user_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('tournament_id');

            $table->string('rank');
            $table->string('best_rank');

            $table->float('rating');
            $table->float('rd');
            $table->float('pps');
            $table->float('apm');
            $table->float('vs');
            $table->integer('games_played');

            $table->unique(['user_id', 'tournament_id']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tetrio_user_snapshots');
    }
};
