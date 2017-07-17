<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Seeders
        $this->call(StudentSeeder::class);
        $this->call(StaffSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(WizardSeeder::class);
        
        // Student Record Seeders
        $this->call(EnrolmentStatusSeeder::class);
        $this->call(ModeOfStudySeeder::class);
        $this->call(StudentStatusSeeder::class);
        $this->call(ProgrammeSeeder::class);
        $this->call(CollegeSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(FundingTypeSeeder::class);
        $this->call(StudentRecordSeeder::class);
    }
}