<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id(); // Mã vấn đề báo cáo
            // Khóa ngoại tham chiếu đến computers.id
            $table->foreignId('computer_id')->constrained('computers')->onDelete('cascade'); 
            $table->string('reported_by', 50)->nullable(); // Người báo cáo (tùy chọn)
            $table->dateTime('reported_date'); // Thời gian báo cáo
            $table->text('description'); // Mô tả chi tiết
            $table->enum('urgency', ['Low', 'Medium', 'High']); // Mức độ sự cố
            $table->enum('status', ['Open', 'In Progress', 'Resolved']); // Trạng thái hiện tại
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
