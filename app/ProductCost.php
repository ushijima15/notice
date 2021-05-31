<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\ProductTime;
use App\SetupTime;

class ProductCost extends Model
{
    /**
     * 日付へキャストする属性
     *
     * @var array
     */
    protected $dates = ['producted_on', 'started_on', 'finished_on'];

    /**
     * todo
     * 従業員を取得
     */
    public function employees()
    {
        //
    }

    /**
     * todo
     * 作業時間を取得
     */
    public function product_times()
    {
        //
    }

    /**
     * 開始時間を取得
     * 作業開始時間で最も過去のstarted_on
     */
    public function getFastStartedTimeAttribute()
    {
        $first = DB::table('product_times')
            ->where('product_cost_id', $this->id)
            ->select('started_on')
            ->orderBy('started_on')
            ->first();
        
        if ($first) {
            return Carbon::parse($first->started_on);
        } else {
            return null;
        }
    }

    /**
     * 終了時間を取得
     * 段取り、生産で最も最新のfinished_on
     */
    public function getLatestFinishedTimeAttribute()
    {
        $product_latest = DB::table('product_times')
            ->where('product_cost_id', $this->id)
            ->select('updated_at', 'finished_on')
            ->orderBy('updated_at', 'desc')
            ->first();      
    }
    
    /**
     * 合計作業時間を取得
     */
    public function getWorkedTimeAttribute()
    {
        $diff = 0;
        foreach ($this->product_times as $product_time) {
            $start = new Carbon($product_time->started_on);
            $finish = new Carbon($product_time->finished_on);
            $s = $start->diffInSeconds($finish);
            $diff += $s;
        }
        return $diff;
    }

    /**
     * todo
     * 作業状態を取得
     * 未着手、作業中、完了
     */
    public function getDisplayStateAttribute()
    {
        //
    }

    /**
     * 最も早い開始日を取得
     */
    public static function getFastStartedTimeGroupBy($job_no, $resource_id, $item_id)
    {
        $models = ProductCost::where([
            ['job_no', $job_no],
            ['resource_id', $resource_id],
            ['item_id', $item_id],
        ])->get();
        $fast_time = now();
        foreach ($models as $model) {
            $dt = $model->fastStartdTime();
            if ($dt) {
                if ($dt->lt($fast_time)) {
                    $fast_time = $dt;
                }
            }
        }
        return isset($fast_time) ? $fast_time->format('Y-m-d H:i') : null;
    }

    /**
     * 最も遅い終了日を取得
     */
    public static function getLatestFinishedTimeGroupBy($job_no, $resource_id, $item_id)
    {
        $models = ProductCost::where([
            ['job_no', $job_no],
            ['resource_id', $resource_id],
            ['item_id', $item_id],
        ])->get();
        $latest_time = null;
        $is_started = false;
        foreach ($models as $model) {
            if (!$model->is_finished) {
                $is_started = true;
            }
            $dt = $model->latestFinishedTime();
            if ($dt) {
                if ($dt->gt($latest_time)) {
                    $latest_time = $dt;
                }
            }
        }
        if ($is_started) {
            $latest_time = now();
        }
        return isset($latest_time) ? $latest_time->format('Y-m-d H:i') : now()->format('Y-m-d H:i');
    }
}
