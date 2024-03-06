<?php


// Database/Seeders/DepartmentsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsTableSeeder extends Seeder
{
    public function run()
    {
        $departments = ['BA', 'CSE', 'Economics', 'EEE', 'English', 'JCMS', 'Law and HR', 'Pharmacy', 'Political Science', 'Public Health', 'Sociology'];

        foreach ($departments as $department) {
            Department::create(['department_name' => $department]);
        }
    }
}
