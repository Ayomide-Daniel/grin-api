<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid("user_id")->constrained("users")->references('id')->on('users')->onDelete('cascade');
            $table->string("tag");
            $table->string("value");
            $table->timestamps();

            $table->unique(["user_id", "tag"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_settings');
    }
}
