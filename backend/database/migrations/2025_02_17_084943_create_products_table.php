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
            $table->string('name_hu');                      // A termék neve magyarul (kötelező)
            $table->string('name_en');                      // A termék neve angolul (kötelező)
            $table->string('material_hu');                  // A termék anyaga magyarul (kötelező)
            $table->string('material_en');                  // A termék anyaga angolul (kötelező)
            $table->string('description_hu')->nullable();     // A termék leírása magyarul (opcionális)
            $table->string('description_en')->nullable();     // A termék leírása angolul (opcionális)
            $table->decimal('price_hu', 10, 2);             // A termék ára magyar forintban (kötelező)
            $table->decimal('price_en', 10, 2);             // A termék ára angol fontban vagy dollárban (kötelező)
            $table->longText('image_url')->nullable();        // A termék képének URL-je (opcionális)
            $table->integer('stock')->default(0);           // A termék raktárkészlete (alapértelmezett 0)
            $table->string('category_hu')->nullable();      // A termék kategóriája magyarul (opcionális)
            $table->string('category_en')->nullable();      // A termék kategóriája angolul (opcionális)
            $table->timestamps();                          // created_at és updated_at mezők
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
