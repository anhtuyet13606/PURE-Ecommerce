
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Giới hạn 191 ký tự để tránh lỗi MySQL
            $t->string('order_code', 191)->unique();

            $t->string('customer_name');
            $t->string('email');
            $t->string('phone');
            $t->string('address');
            $t->decimal('subtotal', 12, 2);
            $t->decimal('shipping_fee', 12, 2)->default(0);
            $t->decimal('discount', 12, 2)->default(0);
            $t->decimal('total', 12, 2);
            $t->string('payment_method');
            $t->string('payment_status')->default('pending');
            $t->string('status')->default('pending');
            $t->text('notes')->nullable();
            $t->timestamps();
        });

        Schema::create('order_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $t->string('product_name');
            $t->decimal('price', 12, 2);
            $t->unsignedInteger('quantity');
            $t->decimal('line_total', 12, 2);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
