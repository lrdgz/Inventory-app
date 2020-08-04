<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Image;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return response()->json($employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:employees|max:255',
            'email' => 'required|email|unique:employees|max:50',
            'phone' => 'required|unique:employees|max:50',
        ]);

        $employee = new Employee;
        $image_url = null;

        try{
            if ($request->photo) {
                $position = strpos($request->photo, ';');
                $sub = substr($request->photo, 0, $position);
                $ext = explode('/', $sub)[1];

                $time = time();
                $name = "{$time}.{$ext}";
                $img = Image::make($request->photo)->resize(240, 200);
                $upload_path = '/backend/employee';
                $image_url = "{$upload_path}/{$name}";
                $img->save($image_url);
            }

            $employee->name         = $request->name;
            $employee->email        = $request->email;
            $employee->phone        = $request->phone;
            $employee->salary       = $request->salary;
            $employee->address      = $request->address;
            $employee->photo        = $image_url;
            $employee->nid          = $request->nid;
            $employee->joining_date = $request->joining_date;

            $employee->save();
            return response()->json(['message' => 'Successfully Created', 'employee' => $employee], 200);

        } catch (\Exception $e){
            return response()->json(['message' => 'Error Creating Employee', 'employee' => []], 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = DB::table('employees')->where('id', $id)->first();
        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [];
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['salary'] = $request->salary;
        $data['address'] = $request->address;
        $data['nid'] = $request->nid;
        $data['joining_date'] = $request->joining_date;

        $image = $request->newphoto;
        $success = false;
        $image_url = '';

        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $time = time();
            $name = "{$time}.{$ext}";
            $img = Image::make($image)->resize(240, 200);
            $upload_path = 'backend/employee';
            $image_url = "{$upload_path}/{$name}";
            $success = $img->save($image_url);
        }

        if($success) {
            $data['photo'] = $image_url;
            $employee = DB::table('employees')->where('id', $id)->first();
            $photo = $employee->photo;
            if($photo){
                unlink($photo);
            }
        } else {
            $data['photo'] = $request->photo;
        }

        $employee = DB::table('employees')->where('id', $id)->update($data);

        return response()->json(['message' => 'Successfully Updated', 'employee' => $employee], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = DB::table('employees')->where('id', $id)->first();
        $photo = $employee->photo;
        if($photo){
            unlink($photo);
        }
        DB::table('employees')->where('id', $id)->delete();
    }
}
