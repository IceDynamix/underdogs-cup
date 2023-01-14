<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('player_blacklist_entries', function (Blueprint $table) {
            $table->id();

            $table->string('tetrio_id')->index();
            $table->timestamp('until')->nullable();
            $table->string('admin_id');
            $table->string('reason');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('player_blacklist_entries');
    }
};
