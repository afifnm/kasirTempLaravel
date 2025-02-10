<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Temp;
use App\Models\Transaction;
use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Transaction Page',
            'transactions' => Transaction::all(),
        ];
        return view('transaction',$data);
    }
    public function invoice($id){
        $data = [
            'title' => 'Invoice Page',
            'transactions' => Transaction::where('invoice',$id)->first(),
            'details' => Detail::with('product')->where('invoice',$id)->get(),
        ];
        return view('invoice',$data);
    }
    public function struk($id){
        $data = [
            'title' => 'Invoice Page',
            'transactions' => Transaction::where('invoice',$id)->first(),
            'details' => Detail::with('product')->where('invoice',$id)->get(),
        ];
        return view('struk',$data);
    }
    public function sell(){
        $invoice = 'D'.date('Ymd').'U'.Auth::id().'T'.Transaction::count()+1;
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
            if ($cek->qty + 1 > $product->stock) {
                return response()->json(['message' => 'The number of products exceeds stock'], 400);
            } else {
                $cek->qty += 1;
                $cek->save();
                return response()->json(['message' => 'Product quantity updated successfully']);
            }
        } else {
            Temp::create([
                'user_id' => Auth::id(),  
                'product_id' => $request->product_id,
                'qty' => 1,
                'price' => $product->price,
            ]);
            return response()->json(['message' => 'Product successfully added to cart']);
        }
    }
    public function addcartBarcode(Request $request){
        $product = Product::where('barcode', $request->barcode)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $cek = Temp::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->first();
        if ($cek) {
            if ($cek->qty + 1 > $product->stock) {
                return response()->json(['message' => 'The number of products exceeds stock'], 400);
            } else {
                $cek->qty += 1;
                $cek->save();
                return response()->json(['message' => 'Product quantity updated successfully']);
            }
        } else {
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
        $product = Product::where('id', $cek->product_id)->first();
        if ($cek) {
            if ($request->qty > $product->stock) {
                return redirect()->route('transaction.sell')->with([
                    'alert'   => 'The number of products exceeds stock',
                    'icon'    => 'error'
                ]);
            } else {
                $cek->qty = $request->qty;
                $cek->save();
                return redirect()->route('transaction.sell')->with([
                    'alert'   => 'The number of products in the cart has been updated',
                    'icon'    => 'success'
                ]);
            }
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
        $invoice = 'D'.date('Ymd').'U'.Auth::id().'T'.Transaction::count()+1;
        $moveToDetails = Temp::where('user_id', Auth::id())->get();
        foreach ($moveToDetails as $item) {
            $product = Product::find($item->product_id);
            if ($item->qty > $product->stock) {
                return redirect()->route('transaction.sell')->with([
                    'alert'   => "Insufficient stock of product {$product->name}. Remaining stock: {$product->stock}.",
                    'icon'    => 'error'
                ]);
            }
        }
        Transaction::create([
            'invoice'   => $invoice,
            'date'      => now(),
            'bill'      => $request->bill,
            'pay'      => $request->pay,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        foreach ($moveToDetails as $item) {
            $data = [
                'invoice'    => $invoice,
                'product_id' => $item->product_id,
                'qty'        => $item->qty,
                'price'      => $item->price,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('details')->insert($data);
            // Kurangi stok produk
            $product = Product::find($item->product_id);
            $product->decrement('stock', $item->qty);
        }
        Temp::where('user_id', Auth::id())->delete();
        return redirect()->route('transaction.sell')->with([
            'alert'   => "Sale completed successfully",
            'icon'    => 'success'
        ]);
    }
}