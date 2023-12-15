<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('baiviet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chude_id')->constrained('chude');
            $table->foreignId('user_id')->constrained('users');
            $table->text('tieude');
            $table->text('tieude_slug');
            $table->text('tomtat')->nullable();
            $table->text('noidung');
            $table->unsignedInteger('luotxem')->default(0);
            $table->unsignedTinyInteger('kiemduyet')->default(1);
            $table->unsignedTinyInteger('kichhoat')->default(1);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baiviet');
    }
};
