<?php
use App\Models\Cart;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

if(! function_exists('totalCartItems')){

    function totalCartItems(): int
    {
        if(Auth::check()){
            return (int) Cart::where('user_id', Auth::id())->sum('product_qty');
        }
       $session_id = session()->getId();
       return (int) Cart::where('session_id', $session_id)->sum('product_qty');
    }
}

if(! function_exists('getBaseCurrency')) {
    function getBaseCurrency()
    {
        return Currency::where('is_base', true)->first();
    }
}

if(! function_exists('getCurrencyCurrency')){
    function getCurrencyCurrency()
    {
        $code = Session::get('currency_code') ?: Cookie::get('currency_code');
        if($code)
            {
                $c = Currency::where('code', $code)->where('status', 1)->first();
                if($c) return $c;
            }

            return getBaseCurrency();
    }
}

if(! function_exists('formatCurrency')){
    function formatCurrency($amount)
    {
        $currency = getCurrencyCurrency();
        if(!$currency){
            return number_format((float)$amount,2);
        }
        $rate = (float)$currency->rate;
        $converted = (float)$amount * $rate;
        //simple formatting: symbol immediately before number
        return ($currency->symbol ?? $currency->code) . number_format($converted, 2);
    }
}
