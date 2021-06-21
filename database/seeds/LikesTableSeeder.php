<?php

use Illuminate\Database\Seeder;
use App\Like;
class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Like;$model->user_id = 1;$model->tweet_id=2;;$model->reaction_no=2;$model->save();
        $model = new Like;$model->user_id = 1;$model->tweet_id=2;;$model->reaction_no=1;$model->save();
        $model = new Like;$model->user_id = 1;$model->tweet_id=3;;$model->reaction_no=2;$model->save();
        $model = new Like;$model->user_id = 1;$model->tweet_id=3;;$model->reaction_no=1;$model->save();
    }
}