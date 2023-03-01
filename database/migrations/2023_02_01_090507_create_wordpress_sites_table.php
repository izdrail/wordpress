<?php

use Cornatul\Feeds\Models\Feed;
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
        Schema::create('wordpress_websites', static function (Blueprint $table) {
            $table->id();
            $table->string('database_host')->nullable();
            $table->string('database_user')->nullable();
            $table->string('database_pass')->nullable();
            $table->string('database_name')->nullable();
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
        Schema::dropIfExists('wordpress_websites');
    }
};
