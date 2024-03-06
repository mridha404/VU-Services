<?php

// Database/Seeders/StudentsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Department;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $departments = Department::all();

        foreach ($departments as $department) {
            $this->seedStudentsForDepartment($department);
        }
    }

    private function seedStudentsForDepartment(Department $department)
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $rollNumber = '1613110' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $mobileNumber = '0171165' . str_pad($i, 6, '0', STR_PAD_LEFT);

            Student::create([
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'rollnumber' => $rollNumber,
                'mobile_number' => $mobileNumber,
                'department_id' => $this->getRandomDepartmentId(),
                'user_id' => 1, // Uncomment and set a valid user_id if needed
            ]);
        }
    }

    private function getRandomDepartmentId()
    {
        // Assuming there are 20 departments in the database
        return Department::inRandomOrder()->first()->id;
    }
}
