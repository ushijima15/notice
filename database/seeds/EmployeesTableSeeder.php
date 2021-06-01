<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\Department;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // todo
        // モックアップに記されている名前を追加
        $model = new Employee;$model->user_id = 2;$model->last_name = 'MG1';$model->first_name = '管理';$model->save();
        $model = new Employee;$model->user_id = 2;$model->last_name = 'MG2';$model->first_name = '上';$model->save();
        $model = new Employee;$model->user_id = 2;$model->last_name = 'MG3';$model->first_name = '下';$model->save();
    }
}
