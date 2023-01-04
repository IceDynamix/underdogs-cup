<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tetrio_users', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->string('username');
            $table->string('country')->nullable();

            $table->string('rank');
            $table->string('best_rank');

            $table->float('rating');
            $table->float('rd');
            $table->float('pps');
            $table->float('apm');
            $table->float('vs');
            $table->integer('games_played');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tetrio_users');
    }
};
