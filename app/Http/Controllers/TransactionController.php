<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

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
        $data = [
            'title' => 'Transaction Page',
            'transactions' => Transaction::all()
        ];
        return view('transactionSell',$data);
    }
}
