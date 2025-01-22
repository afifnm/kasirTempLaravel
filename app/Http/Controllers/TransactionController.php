<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Temp;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Transaction Page',
            'transactions' => Transaction::all()
        ];
        return view('transaction',$data);
    }
    public function sell(){
        $invoice = date('Ymd').Transaction::count()+1;
        $temps = Temp::with('product')->where('user_id', Auth::id())->get();
        $data = [
            'title' => 'Transaction Page',
            'transactions' => Transaction::all(),
            'products' => Product::all(),
            'temps' => $temps,
            'invoice'  => $invoice
        ];
        return view('transactionSell',$data);
    }
    public function addcart(Request $request){
        $product = Product::where('id', $request->product_id)->first();
        $cek = Temp::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)->first();
        if ($cek) {
            // Jika jumlah di temp + 1 lebih dari stok produk
            if ($cek->qty + 1 > $product->stock) {
                return response()->json(['message' => 'The number of products exceeds stock'], 400);
            } else {
                // Jika stok mencukupi, tambahkan qty
                $cek->qty += 1;
                $cek->save();
                return response()->json(['message' => 'Product quantity updated successfully']);
            }
        } else {
            Temp::create([
                'user_id' => Auth::id(),  // Ambil user_id yang sedang login
                'product_id' => $request->product_id,
                'qty' => 1,
                'price' => $product->price,
            ]);
            return response()->json(['message' => 'Product successfully added to cart']);
        }
    }
    public function addcartBarcode(Request $request)
    {
        // Mencari produk berdasarkan barcode
        $product = Product::where('barcode', $request->barcode)->first();
    
        // Jika produk tidak ditemukan, beri respons error
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // Cek apakah produk sudah ada di keranjang pengguna
        $cek = Temp::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->first();
    
        if ($cek) {
            // Jika produk sudah ada, tambahkan 1 ke qty
            $cek->qty += 1;
            $cek->save();
            return response()->json(['message' => 'The number of products in the cart has been increased']);
        } else {
            // Jika produk belum ada, buat item baru di keranjang
            Temp::create([
                'user_id' => Auth::id(),  // Ambil user_id yang sedang login
                'product_id' => $product->id,  // Gunakan product->id
                'qty' => 1,
                'price' => $product->price,
            ]);
            return response()->json(['message' => 'Product successfully added to cart']);
        }
    }
    
    public function cartUpdate(Request $request){
        $cek = Temp::where('id', $request->id)->first();
        if ($cek) {
            $cek->qty = $request->qty;
            $cek->save();
            return redirect()->route('transaction.sell')->with([
                'alert'   => 'The number of products in the cart has been updated',
                'icon'    => 'success'
            ]);
        } 
    }
    public function cartList(){
        $temps = Temp::with('product')->where('user_id', Auth::id())->get();
        return view('partials.cart', compact('temps'));
    }
    public function cartDelete($id){
        $cartItem = Temp::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('transaction.sell')->with('success', 'Product successfully removed from cart.');
        }    
    }
    public function pay(Request $request){
        $moveToDetails = Temp::where('user_id', Auth::id())->get();
        foreach ($moveToDetails as $item) {
            $data = [
                'invoice'    => $request->invoice,
                'product_id' => $item->product_id,
                'qty'        => $item->qty,
                'price'      => $item->price,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('details')->insert($data);
        }
        Temp::where('user_id', Auth::id())->delete();
    }
}