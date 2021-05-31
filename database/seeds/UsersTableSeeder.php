<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new User;$model->name = 'admin';$model->password = bcrypt('9998');$model->is_admin = true;$model->save();
        $model = new User;$model->name = 'user01';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user02';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user03';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user04';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user05';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user06';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user07';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user08';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user09';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user10';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user11';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user12';;$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
        $model = new User;$model->name = 'user13';$model->password = bcrypt('1234');$model->is_admin = false;$model->save();
    }
}
