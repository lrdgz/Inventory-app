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
}
