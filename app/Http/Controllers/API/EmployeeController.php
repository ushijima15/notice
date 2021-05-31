<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeForList as EmployeeForListResource;
use App\Http\Resources\EmployeeForShow as EmployeeForShowResource;
use App\Http\Resources\EmployeeForSelector as EmployeeForSelectorResource;
use App\Employee;
use App\User;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return EmployeeForListResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = User::where([
            ['name', $request->employee['user_name']]
        ])->count();
        if ($count) {
            return response()->json([
                'result' => false,
                'errorMessage' => 'ユーザIDは既に登録されています。'
            ]);
        }
        DB::transaction(function () use ($request) {
            // todo 
            // Userテーブル保存
            
            // todo
            // Employeeテーブルに保存

        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return new EmployeeForShowResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $count = User::where([
            ['id', '<>', $employee->user_id],
            ['name', $request->employee['user_name']]
        ])->count();
        if ($count) {
            return response()->json([
                'result' => false,
                'errorMessage' => 'ユーザIDは既に登録されています。'
            ]);
        }
        DB::transaction(function () use ($request, $employee) {
            $user = $employee->user;
            $user->name =  $request->employee['user_name'];
            if (array_key_exists('password', $request->employee) && $request->employee['password']) {
                $user->password = bcrypt($request->employee['password']);
            }
            $user->is_admin = $request->employee['is_admin'];
            $user->save();
            
            // todo
            // 従業員のデータを上書き保存
            
        });

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if (isset($employee->user_id)) {
            $employee->user->delete();
        }
        $employee->delete();

        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * セレクトボックス用
     *
     * @return \Illuminate\Http\Response
     */
    public function selector()
    {
        $employees = Employee::all();
        return EmployeeForSelectorResource::collection($employees);
    }

}
