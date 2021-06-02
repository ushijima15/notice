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
        $model = new Employee;$model->user_id = 1;$model->last_name = 'MG';$model->first_name = '管理';$model->last_phonetic_name='エムジー';$model->first_phonetic_name='カンリ';$model->save();
        $model = new Employee;$model->user_id = 2;$model->last_name = 'MG';$model->first_name = '太郎';$model->last_phonetic_name='エムジー';$model->first_phonetic_name='タロウ';$model->save();
        $model = new Employee;$model->user_id = 3;$model->last_name = 'MG';$model->first_name = '次郎';$model->last_phonetic_name='エムジー';$model->first_phonetic_name='ジロウ';$model->save();
        $model = new Employee;$model->user_id = 4;$model->last_name = 'MG';$model->first_name = '三郎';$model->last_phonetic_name='エムジー';$model->first_phonetic_name='サブロウ';$model->save();
        $model = new Employee;$model->user_id = 5;$model->last_name = 'MG';$model->first_name = '四郎';$model->last_phonetic_name='エムジー';$model->first_phonetic_name='シロウ';$model->save();
        $model = new Employee;$model->user_id = 6;$model->last_name = 'MG';$model->first_name = '五郎';$model->last_phonetic_name='エムジー';$model->first_phonetic_name='ゴロウ';$model->save();
    }
}
