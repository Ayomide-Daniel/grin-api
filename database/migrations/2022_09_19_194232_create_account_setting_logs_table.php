<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSettingLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_setting_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid("account_setting_id")->constrained("account_settings")->references('id')->on('account_settings')->onDelete('cascade');
            $table->string("tag");
            $table->string("value");
            $table->json("meta")->nullable();
            $table->timestamps();

            // indices
            $table->index(["account_setting_id", "tag"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_setting_logs');
    }
}
