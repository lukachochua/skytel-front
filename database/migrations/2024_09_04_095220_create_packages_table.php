<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tv_plan_id');
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('tv_plan_id')
                ->references('id')->on('tv_plans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropForeign(['tv_plan_id']);
        });

        Schema::dropIfExists('packages');
    }
};
