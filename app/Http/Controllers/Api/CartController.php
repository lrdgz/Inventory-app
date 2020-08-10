<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;


class CartController extends Controller
{
    public function addToCart(Request $request, Product $product){
        $data = [];

        $check = DB::table('pos')->where('pro_id', $product->id)->first();
        $result = null;
        if($check) {
            $result = DB::table('pos')->where('pro_id', $product->id)->increment('pro_quantity');
            $update = DB::table('pos')->where('pro_id',  $product->id)->first();
            $subtotal = $update->pro_quantity * $update->product_price;
            DB::table('pos')->where('pro_id', $update->pro_id)->update(['sub_total' => $subtotal]);

        } else {
            $data['pro_id'] = $product->id;
            $data['pro_name'] = $product->product_name;
            $data['pro_quantity'] = 1;
            $data['product_price'] = $product->selling_price;
            $data['sub_total'] = $product->selling_price;
            $result = DB::table('pos')->insert($data);

        }
        return response()->json($result);
    }

    public function cartProduc(){
        $cart = DB::table('pos')->get();
        return response()->json($cart);
    }

    public function removeCart($id){
        DB::table('pos')->where('id', $id)->delete();
        return response()->json('Done');
    }

    public function incrementCart($id){
        DB::table('pos')->where('id', $id)->increment('pro_quantity');
        $product = DB::table('pos')->where('id', $id)->first();
        $subtotal = $product->pro_quantity * $product->product_price;
        DB::table('pos')->where('id', $id)->update(['sub_total' => $subtotal]);
        return response()->json('Done');
    }

    public function decrementCart($id){
        $quantity = DB::table('pos')->where('id', $id)->decrement('pro_quantity');
        $product = DB::table('pos')->where('id', $id)->first();
        $subtotal = $product->pro_quantity * $product->product_price;
        DB::table('pos')->where('id', $id)->update(['sub_total' => $subtotal]);
        return response()->json('Done');
    }

}
