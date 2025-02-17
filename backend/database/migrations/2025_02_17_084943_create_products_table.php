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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                         // A termék neve (kötelező)
            $table->string('material');                     // A termék anyaga (kötelező)
            $table->text('description')->nullable();        // A termék leírása (opcionális)
            $table->decimal('price');                       // A termék ára (kötelező)
            $table->string('image_url')->nullable();        // A termék képének URL-je (opcionális)
            $table->integer('stock')->default(0);    // A termék raktárkészlete (alapértelmezett 0)
            $table->string('category')->nullable();         // A termék kategóriája (opcionális)
            $table->timestamps();                                   // created_at és updated_at mezők
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
