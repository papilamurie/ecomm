<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CurrencySwitchController extends Controller
{
    public function switch(Request $request)
    {
        $code = $request->input('code');
        if(!$code) return response()->json(['status'=>'error','message'=>'Currency code missing'],400);
        $currency = Currency::where('code',$code)->where('status',1)->first();
        if(!$currency) return response()->json(['status'=>'error','message'=>'Currency not Available'],404);
        Session::put('currency_code',$currency->code);
        Cookie::queue('currency_code',$currency->code, 7*24*60); //7 days in minutes
        return response()->json(['status'=>'success','code'=>$currency->code,'symbol'=>$currency->symbol,'rate'=>$currency->rate]);
    }
}
