<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model{
    use HasFactory;
    protected $fillable = [
        'invoice',
        'date',
        'bill',
        'pay'
    ];
    public static function billToday(){
        return self::whereDate('date', Carbon::today())->sum('bill');
    }
    public static function billMonth(){
        return self::whereMonth('date', Carbon::now()->month)
                    ->whereYear('date', Carbon::now()->year)
                    ->sum('bill');
    }
    public static function getRecent($limit){
        return self::orderBy('date', 'desc')
                    ->limit($limit)
                    ->get();
    }
}
