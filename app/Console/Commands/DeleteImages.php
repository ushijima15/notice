<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Image;

class DeleteImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '不要添付ファイル削除';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $target_date = date('Y-m-d', strtotime("-1 month"));
       
        $unnecessary_images = Image::doesntHave('lathe_direction_images')
        ->doesntHave('machining_direction_images')
        ->where('images.created_at', '<', $target_date)
        ->get();

        foreach ($unnecessary_images as $unnecessary_image) {
            if($unnecessary_image) {
                $unnecessary_image->deleteWithFile();
            } 
        }
        $this->myLogger('ファイルを削除しました。');
    }

    private function myLogger($msg)
    {
        $this->info($msg);
        Logger()->info($msg);
    }
    
}
