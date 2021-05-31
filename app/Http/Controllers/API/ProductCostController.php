<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\ProductCost;
use App\ProductTime;
use App\ProductBreakTime;
use App\FinishingTime;
use App\NoworkTime;
use App\CsvDownload;
use App\SetupTime;
use App\SetupBreakTime;
use App\ProductBreakTimeInterruption;
use Response;
use App\Http\Resources\ProductCostForList as ProductCostForListResource;
use App\Http\Resources\ProductCostResume as ProductCostResumeResource;
use App\Http\Resources\ProductCostEdit as ProductCostEditResource;
use App\Http\Resources\ProductTime as ProductTimeResource;
use App\Http\Resources\ProductBreakTime as ProductBreakTimeResource;
use App\Http\Resources\SetupTime as SetupTimeResource;
use App\Http\Resources\SetupBreakTime as SetupBreakTimeResource;
use App\Http\Resources\FinishingTime as FinishingTimeResource;
use App\Http\Resources\ProductCostForCsv as ProductCostForCsvResource;
use App\Http\Resources\ItemSelector as ItemSelectorResource;
use App\Http\Resources\NoworkTime as NoworkTimeResource;
use App\Http\Resources\SelectorForSubject as SelectorForSubjectResource;
use Carbon\Carbon;
use Exception;

class ProductCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        // todo
        // requestでデータを取得
        
        $query = ProductCost::when($selected_line_no, function ($query) use ($selected_line_no) {
            // 検索ができるようにここに書く
            
        })
        ;
        
        $count_items = $query->count();
        
        $line_numbers = ProductCost::groupBy('line_no')->pluck('line_no');        
        
        $sort = json_decode($request->sort, true);
        
        $product_costs = $query->offset($offset)
        ->limit($limit)
        ->get();

        if ($sort['isAsc']) {
            $product_costs = $query->orderBy("{$sort['key']}", 'asc')->offset($offset)->limit($limit)->get();
        } else {
            $product_costs = $query->orderBy("{$sort['key']}", 'desc')->offset($offset)->limit($limit)->get();
        }

        return response()->json([
            'line_numbers' => $line_numbers,
            'total_items' => $count_items,
            'product_costs' => ProductCostForListResource::collection($product_costs),
        ]);
    }

    /**
     * 続きの入力
     *
     * @param  ProductCost  $productcost
     * @return \Illuminate\Http\Response
     */
    public function resume(ProductCost $productcost)
    {
        return new ProductCostResumeResource($productcost);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ProductCost  $productcost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCost $productcost)
    {   
        $productcost = DB::transaction(function () use ($request, $productcost) {
            $productcost->actual_quantity = $request->product_cost['actual_quantity'];
            $productcost->save();
        });
        
        return response()->json([
            'result' => true,
            'product_cost' => new ProductCostResumeResource(ProductCost::find($productcost->id)),
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductCost  $productcost
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCost $productcost)
    {
        DB::transaction(function () use ($productcost) {
            foreach ($productcost->product_times as $product_time) {
                $product_time->delete();
            }
            $productcost->delete();
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * 作業開始
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function startProductTime(Request $request, ProductCost $product_cost)
    {
        $payload = $request->all();
        [$product_time, $product_cost, $setup_time] = DB::transaction(function () use ($payload, $product_cost) {
            // todo
            // 開始時間の登録をする
            

            Arr::set($payload, 'state.product_time', new ProductTimeResource($product_time));
            $product_cost->state = json_encode($payload['state']);
            $product_cost->save();

            return [$product_time, $product_cost];
        });

        return response()->json([
            'result' => true,
            'product_time' => new ProductTimeResource($product_time),
            'product_cost' => new ProductCostResumeResource(ProductCost::find($product_cost->id)),
        ]);
    }
    
    /**
     * 作業終了
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finishProductTime(Request $request, ProductTime $product_time)
    {
        $payload = $request->all();
        [$product_time, $product_cost, $product_copy] = DB::transaction(function () use ($payload, $product_time) {
            // todo
            // 終了時間（現在時刻）をproduct_timeに登録する
            
            
            Arr::set($payload, 'state.product_time', new ProductTimeResource($product_time));
            $product_cost = $product_time->product_cost;
            $product_cost->state = json_encode($payload['state']);
            $product_cost->save();
            
            return [$product_time, $product_cost];
        });

        return response()->json([
            'result' => true,
            'product_time' => new ProductTimeResource($product_time),
            'finished_time' => $product_cost->finished_time,
            'product_cost' => new ProductCostResumeResource(ProductCost::find($product_cost->id)),
        ]);
    }

    /**
     * 全工程終了
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function allFinish(Request $request, ProductCost $product_cost)
    {
        $payload = $request->all();
        DB::transaction(function () use ($payload, $product_cost) {

            $product_cost->actual_quantity = $payload['product_cost']['actual_quantity'];
            $product_cost->is_finished = true;
            $product_cost->save();
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * CSV取込
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        DB::transaction(function () use ($request) {
            $csv_orders = collect($request->orders);

            foreach ($csv_orders as $csv_order) {
                $product_cost = ProductCost::where('product_code', $csv_order['col1'])->first();

                if (!isset($product_cost)) {
                    $product_cost = new ProductCost;
                } 

                // 作業日、ラインNo、順番、品目、C/T(min)、指示日、指示数、納入指示数
                $date = $csv_order['col1'];
                $old_date = explode('/', $date);
                $new_date = $old_date[2].'/'.$old_date[0].'/'.$old_date[1];
                $product_cost->worked_on = $new_date;
                
                $product_cost->line_no = $csv_order['col2'];
                $product_cost->order_no = $csv_order['col3'];
                $product_cost->product_code = $csv_order['col4'];
                $product_cost->c_t = $csv_order['col5'];
                $date = $csv_order['col6'];
                $old_date = explode('/', $date);
                $new_date = $old_date[2].'/'.$old_date[0].'/'.$old_date[1];
                $product_cost->deliveried_on = $new_date;
                
                $product_cost->order_quantity = $csv_order['col7'];
                $product_cost->deliveried_quantity = $csv_order['col8'];
                
                $product_cost->save();
            }
        });
        return response()->json([
            'result' => true,
        ]);
    }
    
    /**
     * CSV最終更新時間
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finishCSVtime()
    {
        $max_created_at = ProductCost::max('created_at');
        return response()->json([
            'finishCSVtime' => $max_created_at ? Carbon::parse($max_created_at)->format('Y/m/d H:i:s') : null,
        ]);
    }

    /**
     * CSVダウンロード
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function download(Request $request)
    {
        $stream = fopen('php://temp', 'w');
        $output_header = [
            //
        ];
        mb_convert_variables('UTF-8', 'UTF-8', $output_header);
        fputcsv($stream, $output_header);
        $from = $request->from;
        $to = $request->to;
        
        $product_costs = ProductCost::when($from, function ($query) use ($from) {
            return $query->whereDate('worked_on', '>=', $from);
        })
        ->when($to, function ($query) use ($to) {
            return $query->whereDate('worked_on', '<=', $to);
        })
        ->where('state', '<>', null)
        ->select('product_costs.*')
        
        ->orderBy('worked_on')
        ->distinct()
        ->get();
            
        foreach ($product_costs as $index => $product_cost) {
            fputcsv($stream, [
                // todo
                // 作業日、作業者、ラインNo、部品番号、納入指示日

                // 稼働時間、開始時間、終了時間

                // 指示数、C/T(min)、製作数量

            ]);
        }

        rewind($stream);
        $csv = str_replace(PHP_EOL, "\r\n", stream_get_contents($stream));

        $filename = '作業日報.csv';

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename. '"'
        );

        fclose($stream);

        return Response::make($csv, 200, $headers);
    }

    /**
     * 秒 -> 時,分,秒の変換
     */
    public function convertTime($val)
    {
        // val は 秒
        if (!$val) {
            return '00:00';
        }
        $hours = floor($val / 3600);
        $minutes = floor(($val / 60) % 60);
        $seconds = $val % 60;

        return $hours.':'.$minutes.':'.$seconds ; 
    }

    /**
     * 件名検索用
     *
     * @return \Illuminate\Http\Response
     */
    public function selectorForSearch(Request $request)
    {
        $code = $request->code;
        $name = $request->name;
        $subjects = ProductCost::when($code, function ($query) use ($code) {
            return $query->where('product_code', 'like', '%'.$code.'%');
        })
        ->when($name, function ($query) use ($name) {
            return $query->where('subject', 'like', '%'.$name.'%');
        })
        ->get();

        return SelectorForSubjectResource::collection($subjects);
    }

    /**
     * セレクトボックス用
     *
     * @return \Illuminate\Http\Response
     */
    public function itemSelector(Request $request)
    {
        $payload = $request->all();
        $items = ProductCost::itemSelector($payload);
        return ItemSelectorResource::collection($items);
    }
}
