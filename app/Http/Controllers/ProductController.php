<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller{
    public function index(){
        $data = [
            'title' => 'Product Page',
            'products' => Product::all()
        ];
        return view('product',$data);
    }
    public function store(Request $request){
        $validated = $request->validate(([
            'name'  => 'required|string|max:255',
            'barcode' => 'required|string|unique:products',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]));
        $product = new Product();
        $product->name = $validated['name'];
        $product->barcode = $validated['barcode'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->save();
        return redirect()->route('product')->with([
            'alert'   => 'Product added successfully',
            'icon'    => 'success'
        ]);
    }
    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product')->with([
            'alert'   => 'Product has been deleted',
            'icon'    => 'success'
        ]);
    }
    public function update(Request $request, $id){
        // Ambil data produk berdasarkan ID
        $product = Product::findOrFail($id);
        // Update data produk
        $product->name = $request->input('name');
        $product->barcode = $request->input('barcode');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->save(); // Simpan perubahan
        return redirect()->route('product')->with([
            'alert'   => 'Product updated successfully',
            'icon'    => 'success'
        ]);
    }
}
