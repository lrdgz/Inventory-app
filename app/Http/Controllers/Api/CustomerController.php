<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Image;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'DESC')->get();
        return response()->json($customers);

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
            'name' => 'required|max:255',
            'email' => 'email|unique:employees|max:50',
            'phone' => 'required|unique:employees|max:50',
        ]);

        $customer = new Customer;
        $image_url = null;

        try{
            if ($request->photo) {
                $position = strpos($request->photo, ';');
                $sub = substr($request->photo, 0, $position);
                $ext = explode('/', $sub)[1];

                $time = time();
                $name = "{$time}.{$ext}";
                $img = Image::make($request->photo)->resize(240, 200);
                $upload_path = 'backend/customer';
                $image_url = "{$upload_path}/{$name}";
                $img->save($image_url);
            }

            $customer->name         = $request->name;
            $customer->email        = $request->email;
            $customer->phone        = $request->phone;
            $customer->address      = $request->address;
            $customer->photo        = $image_url;

            $customer->save();
            return response()->json(['message' => 'Successfully Created', 'customer' => $customer], 200);

        } catch (\Exception $e){
            return response()->json(['message' => 'Error Creating Customer', 'customer' => []], 400);
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
        $customer = DB::table('customers')->where('id', $id)->first();
        return response()->json($customer);
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
        $data['address'] = $request->address;

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
            $upload_path = 'backend/customer';
            $image_url = "{$upload_path}/{$name}";
            $success = $img->save($image_url);
        }

        if($success) {
            $data['photo'] = $image_url;
            $customer = DB::table('customers')->where('id', $id)->first();
            $photo = $customer->photo;
            if($photo){
                unlink($photo);
            }
        } else {
            $data['photo'] = $request->photo;
        }

        $customer = DB::table('customers')->where('id', $id)->update($data);

        return response()->json(['message' => 'Successfully Updated', 'customer' => $customer], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
        $photo = $customer->photo;
        if($photo){
            unlink($photo);
        }
        DB::table('customers')->where('id', $id)->delete();
    }
}
