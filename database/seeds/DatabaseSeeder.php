<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        // todo 
        $this->call(EmployeesTableSeeder::class);
        $this->call(TestsTableSeeder::class);
        $this->call(TweetsTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(NoticesTableSeeder::class);
    }
}
