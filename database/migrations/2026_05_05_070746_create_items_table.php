<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->unsignedInteger('quantity')->default(0);
        $table->decimal('price', 12, 2)->default(0);
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
