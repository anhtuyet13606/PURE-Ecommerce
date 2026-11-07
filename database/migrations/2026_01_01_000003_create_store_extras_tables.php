
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $t) {
            $t->id();

            // Đã sửa độ dài code thành 191
            $t->string('code', 191)->unique();

            $t->string('description')->nullable();
            $t->enum('type', ['fixed', 'percent'])->default('fixed');
            $t->decimal('value', 12, 2);
            $t->decimal('min_order', 12, 2)->default(0);
            $t->decimal('max_discount', 12, 2)->nullable();
            $t->unsignedInteger('usage_limit')->nullable();
            $t->unsignedInteger('used_count')->default(0);
            $t->dateTime('starts_at')->nullable();
            $t->dateTime('expires_at')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });

        Schema::create('wishlists', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->unique(['user_id', 'product_id']);
        });

        Schema::create('reviews', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $t->unsignedTinyInteger('rating');
            $t->string('title')->nullable();
            $t->text('content')->nullable();
            $t->boolean('is_approved')->default(false);
            $t->timestamps();
            $t->unique(['user_id', 'product_id', 'order_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('coupons');
    }
};
