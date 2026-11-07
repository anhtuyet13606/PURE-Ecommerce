
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // BẢNG DANH MỤC
        Schema::create('categories', function (Blueprint $t) {
            $t->id();

            $t->string('name', 191);
            $t->string('slug', 191)->unique();

            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true);

            $t->timestamps();
        });

        // BẢNG SẢN PHẨM
        Schema::create('products', function (Blueprint $t) {
            $t->id();

            $t->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            $t->string('name', 191);
            $t->string('slug', 191)->unique();
            $t->string('sku', 100)->unique();

            $t->text('description')->nullable();

            $t->decimal('price', 12, 2);
            $t->decimal('sale_price', 12, 2)->nullable();

            $t->unsignedInteger('stock')->default(0);
            $t->string('image')->nullable();

            $t->boolean('is_active')->default(true);
            $t->boolean('featured')->default(false);

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
