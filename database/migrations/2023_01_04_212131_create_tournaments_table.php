<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->string('name')->unique();

            $table->string('bracket_url')->nullable();
            $table->string('status')->default('upcoming');
            $table->boolean('hidden')->default(true);

            $table->mediumText('description');

            $table->dateTime('reg_open_ts')->default(now());
            $table->dateTime('reg_close_ts');
            $table->dateTime('check_in_open_ts');
            $table->dateTime('check_in_close_ts');
            $table->dateTime('tournament_start_ts');

            $table->string('lower_reg_rank_cap')->default('z');
            $table->string('upper_reg_rank_cap')->default('x');
            $table->string('grace_rank_cap')->default('x');

            $table->integer('min_games_played')->default(0);
            $table->integer('max_rd')->default(100);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
};
