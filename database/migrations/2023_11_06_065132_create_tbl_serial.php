<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_serial', function (Blueprint $table) {
            $table->id();
            $table->string('serial');
            $table->unsignedBigInteger('pattern_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('pattern_id')
                ->references('id')
                ->on('tbl_pattern')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_serial');
    }
};
