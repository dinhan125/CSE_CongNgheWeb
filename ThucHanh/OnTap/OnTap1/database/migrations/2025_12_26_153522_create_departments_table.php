<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_departments_table.php

public function up()
{
    Schema::create('departments', function (Blueprint $table) {
        $table->id(); // Khóa chính
        $table->string('name', 100); // Tên phòng ban [cite: 9]
        $table->string('location', 100)->nullable(); // Vị trí
        $table->string('manager', 100)->nullable(); // Tên quản lý
        $table->timestamps(); // created_at, updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
