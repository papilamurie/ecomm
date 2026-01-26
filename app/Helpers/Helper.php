<?php
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

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
