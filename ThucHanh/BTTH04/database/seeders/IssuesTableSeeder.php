<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class IssuesTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        
        // Lấy danh sách ID của máy tính để đảm bảo tính toàn vẹn dữ liệu khóa ngoại
        $computerIds = DB::table('computers')->pluck('id')->toArray();

        foreach (range(1, 50) as $index) {
            DB::table('issues')->insert([
                'computer_id' => $faker->randomElement($computerIds), // Random ID từ bảng computers
                'reported_by' => $faker->optional()->name(), // Có thể null
                'reported_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'description' => $faker->paragraph(2),
                'urgency' => $faker->randomElement(['Low', 'Medium', 'High']),
                'status' => $faker->randomElement(['Open', 'In Progress', 'Resolved']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}