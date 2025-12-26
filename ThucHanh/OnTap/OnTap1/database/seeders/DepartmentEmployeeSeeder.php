<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DepartmentEmployeeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Sinh 5 phòng ban [cite: 17]
        for ($i = 0; $i < 5; $i++) {
            $department = Department::create([
                'name' => 'Phòng ' . $faker->jobTitle,
                'location' => $faker->city,
                'manager' => $faker->name
            ]);

            // Mỗi phòng ban sinh 5-8 nhân viên [cite: 18]
            $numEmployees = rand(5, 8);
            for ($j = 0; $j < $numEmployees; $j++) {
                Employee::create([
                    'department_id' => $department->id,
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'position' => $faker->randomElement(['VP', 'Manager', 'Staff']), // [cite: 49]
                    'salary' => $faker->randomFloat(2, 500, 3000)
                ]);
            }
        }
    }
}
