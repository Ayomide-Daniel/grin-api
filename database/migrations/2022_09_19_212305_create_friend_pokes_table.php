<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendPokesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_pokes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('friend_request_id')->constrained('friend_requests')->references('id')->on('friend_requests')->onDelete('cascade');
            $table->foreignUuid('sender_id')->constrained('users')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('receiver_id')->constrained('users')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();

            // indices
            $table->index(['sender_id', 'receiver_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friend_pokes');
    }
}
