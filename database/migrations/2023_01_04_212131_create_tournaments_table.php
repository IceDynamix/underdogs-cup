<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->string('name')->unique();

            $table->string('bracket_url')->nullable();
            $table->string('status')->default('upcoming');
            $table->boolean('hidden')->default(true);

            $table->mediumText('description')->nullable();

            $table->dateTime('reg_open_ts')->nullable();
            $table->dateTime('reg_close_ts')->nullable();
            $table->dateTime('check_in_open_ts')->nullable();
            $table->dateTime('check_in_close_ts')->nullable();
            $table->dateTime('tournament_start_ts')->nullable();

            $table->string('lower_reg_rank_cap')->nullable();
            $table->string('upper_reg_rank_cap')->nullable();
            $table->string('grace_rank_cap')->nullable();

            $table->integer('min_games_played')->nullable();
            $table->integer('max_rd')->nullable();

            $table->longText('full_description')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tournaments');
    }
};
