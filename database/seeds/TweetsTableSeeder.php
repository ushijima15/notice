<?php

use Illuminate\Database\Seeder;
use App\Tweet;

class TweetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Tweet;$model->text="おはようございます。";$model->save();
        $model = new Tweet;$model->text="こんにちは。";$model->save();
        $model = new Tweet;$model->text="こんばんは！";$model->save();
    }
}
