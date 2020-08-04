<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Image;
use DB;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
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
            'name' => 'required|unique:suppliers|max:255',
            'email' => 'required|email|unique:suppliers|max:50',
            'phone' => 'required|unique:suppliers|max:50',
        ]);

        $supplier = new Supplier;
        $image_url = null;

        try{
            if ($request->photo) {
                $position = strpos($request->photo, ';');
                $sub = substr($request->photo, 0, $position);
                $ext = explode('/', $sub)[1];

                $time = time();
                $name = "{$time}.{$ext}";
                $img = Image::make($request->photo)->resize(240, 200);
                $upload_path = 'backend/supplier';
                $image_url = "{$upload_path}/{$name}";
                $img->save($image_url);
            }

            $supplier->name     = $request->name;
            $supplier->email    = $request->email;
            $supplier->phone    = $request->phone;
            $supplier->address  = $request->address;
            $supplier->shopname = $request->shopname;
            $supplier->photo    = $image_url;

            $supplier->save();
            return response()->json(['message' => 'Successfully Created', 'supplier' => $supplier], 200);

        } catch (\Exception $e){
            return response()->json(['message' => 'Error Creating Supplier', 'supplier' => []], 400);
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
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        return response()->json($supplier);
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
        $data['shopname'] = $request->shopname;
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
            $upload_path = 'backend/supplier';
            $image_url = "{$upload_path}/{$name}";
            $success = $img->save($image_url);
        }

        if($success) {
            $data['photo'] = $image_url;
            $supplier = DB::table('suppliers')->where('id', $id)->first();
            $photo = $supplier->photo;
            if($photo){
                unlink($photo);
            }
        } else {
            $data['photo'] = $request->photo;
        }

        $supplier = DB::table('suppliers')->where('id', $id)->update($data);

        return response()->json(['message' => 'Successfully Updated', 'supplier' => $supplier], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        $photo = $supplier->photo;
        if($photo){
            unlink($photo);
        }
        DB::table('suppliers')->where('id', $id)->delete();
    }
}
