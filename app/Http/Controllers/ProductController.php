<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller{
    
    public function index(){
        $data = [
            'title'     => 'Product Page',
            'products'  => Product::all()
        ];
        return view('product')
    }
    public function store(Request $request){

    }
    public function update(Request $request,$id){

    }
    public function destroy($id){

    }
}
