<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;


class PosController extends Controller
{
    public function getProduct(Category $category){
        $products = DB::table('products')->where('category_id', $category->id)->get();
        return response()->json($products);
    }

    public function orderDone(Request $request){
        $request->validate([
            'customer_id' => 'required',
            'pay_by' => 'required',
        ]);

        $data = [];
        $data['customer_id'] = $request->customer_id;
        $data['qty'] = $request->qty;
        $data['sub_total'] = $request->subtotal;
        $data['vat'] = $request->vat;
        $data['total'] = $request->total;
        $data['pay'] = $request->pay;
        $data['due'] = $request->due;
        $data['pay_by'] = $request->pay_by;
        $data['order_date'] = date('d/m/Y');
        $data['order_month'] = date('F');
        $data['order_year'] = date('Y');

        $order_id = DB::table('orders')->insertGetId($data);

        $contents = DB::table('pos')->get();
        $details = [];

        foreach ($contents as $content){
            $details['order_id'] = $order_id;
            $details['product_id'] = $content->pro_id;
            $details['pro_quantity'] = $content->pro_quantity;
            $details['product_price'] = $content->product_price;
            $details['sub_total'] = $content->sub_total;
            DB::table('order_details')->insert($details);
            DB::table('products')->where('id', $content->pro_id)->update(['product_quantity' => DB::raw('product_quantity - ' . $content->pro_quantity)]);
        }

        DB::table('pos')->delete();
        return response()->json(['message' => 'Done']);
    }
}
