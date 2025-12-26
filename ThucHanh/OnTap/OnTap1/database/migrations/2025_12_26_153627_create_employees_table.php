<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_employees_table.php

    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // Tạo khóa ngoại liên kết với bảng departments
            // onDelete('cascade'): Xóa phòng ban thì nhân viên bị xóa theo [cite: 15]
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('email', 100)->unique(); // Email duy nhất [cite: 11]
            $table->string('phone', 20)->nullable();
            $table->string('position', 50); // VP, Manager, Staff
            $table->decimal('salary', 10, 2); // Lương
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
