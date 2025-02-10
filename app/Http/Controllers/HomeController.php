<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller{
    public function index(){
        $data = [
            'title'     =>  'Dashboard',
            'billToday' => Transaction::billToday(),
            'billMonth' => Transaction::billMonth(),
            'recents'   => Transaction::getRecent(10)
        ];
        return view('dashboard',$data);
    }
}
