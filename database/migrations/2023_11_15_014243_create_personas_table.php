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
        Schema::create('personas', function (Blueprint $table) {
            $table->id(); // id, bigInt, PK, AI, unsigned
            $table->string("nombre_completo", 50);
            $table->string("ci", 15)->nullable();
            $table->boolean("estado")->default(true);
            $table->bigInteger("user_id")->unsigned();

            $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps(); // created_at, updated_at, deleted_at (softDelete)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
