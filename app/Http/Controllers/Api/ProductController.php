<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Image;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')
                    ->join('categories', 'products.category_id', 'categories.id')
                    ->join('suppliers', 'products.supplier_id', 'suppliers.id')
                    ->select(
                        'categories.category_name',
                        'suppliers.name',
                        'products.*'
                    )
                    ->orderBy('products.id', 'DESC')
                    ->get();

        return response()->json($products);
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
            'product_name' => 'required|max:255',
            'product_code' => 'required|unique:products|max:100',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'buying_date' => 'required',
            'product_quantity' => 'required',
        ]);

        $product = new Product;
        $image_url = null;

        try{
            if ($request->image) {
                $position = strpos($request->image, ';');
                $sub = substr($request->image, 0, $position);
                $ext = explode('/', $sub)[1];

                $time = time();
                $name = "{$time}.{$ext}";
                $img = Image::make($request->image)->resize(240, 200);
                $upload_path = 'backend/product';
                $image_url = "{$upload_path}/{$name}";
                $img->save($image_url);
            }

            $product->product_name     = $request->product_name;
            $product->product_code     = $request->product_code;
            $product->category_id      = $request->category_id;
            $product->supplier_id      = $request->supplier_id;
            $product->root             = $request->root;
            $product->buying_price     = $request->buying_price;
            $product->selling_price    = $request->selling_price;
            $product->buying_date      = $request->buying_date;
            $product->product_quantity = $request->product_quantity;
            $product->image = $image_url;

            $product->save();
            return response()->json(['message' => 'Successfully Created', 'product' => $product], 200);

        } catch (\Exception $e){
            echo $e->getMessage();
            return response()->json(['message' => 'Error Creating Product', 'product' => []], 400);
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
        $product = DB::table('products')->where('id', $id)->first();
        return response()->json($product);
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

        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['category_id'] = $request->category_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['root'] = $request->root;
        $data['buying_price'] = $request->buying_price;
        $data['selling_price'] = $request->selling_price;
        $data['buying_date'] = $request->buying_date;
        $data['product_quantity'] = $request->product_quantity;

        $image = $request->newImage;
        $success = false;
        $image_url = '';

        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $time = time();
            $name = "{$time}.{$ext}";
            $img = Image::make($image)->resize(240, 200);
            $upload_path = 'backend/product';
            $image_url = "{$upload_path}/{$name}";
            $success = $img->save($image_url);
        }

        if($success) {
            $data['image'] = $image_url;
            $product = DB::table('products')->where('id', $id)->first();
            $photo = $product->image;
            if($photo){
                unlink($photo);
            }
        } else {
            $data['image'] = $request->image;
        }

        $product = DB::table('products')->where('id', $id)->update($data);

        return response()->json(['message' => 'Successfully Updated', 'product' => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $photo = $product->image;
        if($photo){
            unlink($photo);
        }
        DB::table('products')->where('id', $id)->delete();
    }
}
