
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // BẢNG NGƯỜI DÙNG
        Schema::create('users', function (Blueprint $t) {
            $t->id();

            $t->string('name', 191);
            $t->string('email', 191)->unique();

            $t->timestamp('email_verified_at')->nullable();

            $t->string('password');

            $t->string('phone', 30)->nullable();
            $t->string('address', 255)->nullable();

            $t->string('role', 30)->default('customer');

            $t->rememberToken();
            $t->timestamps();
        });

        // BẢNG ĐẶT LẠI MẬT KHẨU
        Schema::create('password_reset_tokens', function (Blueprint $t) {
            $t->string('email', 191)->primary();
            $t->string('token', 191);
            $t->timestamp('created_at')->nullable();
        });

        // BẢNG PHIÊN ĐĂNG NHẬP
        Schema::create('sessions', function (Blueprint $t) {
            $t->string('id', 191)->primary();

            $t->foreignId('user_id')
                ->nullable()
                ->index();

            $t->string('ip_address', 45)->nullable();
            $t->text('user_agent')->nullable();
            $t->longText('payload');

            $t->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
