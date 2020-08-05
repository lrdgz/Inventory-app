<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Employee;
use DB;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paid(Request $request, Employee $employee)
    {
        $request->validate([
            'salary_month' => 'required',
        ]);

        $month = $request->salary_month;
        $year = date('Y');

        $check = DB::table('salaries')
                ->where('employee_id', $employee->id)
                ->where('salary_month', $month)
                ->where('salary_year', $year)
                ->first();

        if($check){
            return response()->json('Salary Already Paid');
        } else {
            $data = [];
            $data['employee_id'] = $employee->id;
            $data['amount'] = $employee->salary;
            $data['salary_date'] = date('Y-m-d');
            $data['salary_month'] = $month;
            $data['salary_year'] = $year;
            DB::table('salaries')->insert($data);
        }
    }

    public function allSalary(){
        $salaries = DB::table('salaries')
                    ->select('salary_month', 'salary_year', DB::raw("SUM(amount) as total_amount"))
                    ->groupBy('salary_month', 'salary_year')
                    ->get();
        return response()->json($salaries);
    }

    public function viewSalary($year, $month){
        $salaries = DB::table('salaries')
                    ->join('employees', 'salaries.employee_id', 'employees.id')
                    ->select('employees.name', 'salaries.*')
                    ->where('salaries.salary_year', $year)
                    ->where('salaries.salary_month', $month)
                    ->get();

        return response()->json($salaries);
    }

    public function editSalary($id)
    {
        $salary = DB::table('salaries')
            ->join('employees', 'salaries.employee_id', 'employees.id')
            ->select('employees.name', 'employees.email', 'employees.salary', 'salaries.*')
            ->where('salaries.id', $id)
            ->first();

        return response()->json($salary);
    }

    public function updateSalary(Request $request, $id)
    {
        $data = [];
        $data['employee_id'] = $request->employee_id;
        $data['amount'] = $request->amount;
        $data['salary_month'] = $request->salary_month;
        DB::table('salaries')->where('id', $id)->update($data);
    }
}
