<?php

namespace App\Services\front;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CouponService
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function applyCoupon(string $rawCode): array
    {
        $code = strtoupper(trim((string) $rawCode));

        //if Empty Code => clear any applied coupon and refresh cart fragments
        if($code === ''){
            Session::forget(['applied_coupon', 'applied_coupon_id', 'applied_coupon_discount']);
            $cart = $this->cartService->getCart();
            return [
                'status' => false,
                'message' => 'Coupon Code Required',
                'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),
            ];
        }

        //Load Coupon
        $coupon = Coupon::where('coupon_code', $code)->where('status',1)->first();
        if(!$coupon){
            //clear any previous coupon
            Session::forget(['applied_coupon', 'applied_coupon_id', 'applied_coupon_discount']);
            $cart = $this->cartService->getCart();
            return [
                'status' => false,
                'message' => 'Invalid Coupon Code',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
        }

        // Normalize coupon Properties that may be stored on JSON or arrays
        $couponCategories = [];
        if(!empty($coupon->categories)){
            if(is_array($coupon->categories)){
                $couponCategories = $coupon->categories;
            }else{
                $couponCategories = json_decode($coupon->categories, true) ?: (array)$coupon->categories;
            }
        }

        $couponUsers = [];
        if(!empty($coupon->users)){
            if(is_array($coupon->users)){
                $couponUsers = $coupon->users;
            }else{
                $couponUsers = json_decode($coupon->users, true) ?: (array)$coupon->users;
            }
        }

         // Normalize Brands Properties that may be stored on JSON or arrays
        $couponBrands = [];
        if(!empty($coupon->brands)){
            if(is_array($coupon->brands)){
                $couponBrands = $coupon->brands;
            }else{
                $couponBrands = json_decode($coupon->brands, true) ?: (array)$coupon->brands;
            }
        }

        //Expiry Check
        if(!empty($coupon->expiry_date)){
            try{
                $expiry = \Carbon\Carbon::parse($coupon->expiry_date)->endOfDay();
                if(\Carbon\Carbon::now()->gt($expiry)){
                    Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'Coupon has Expired',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
                }
            } catch(\Exception $e){
                // if invalid date format, treat as expired
                 Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'Invalid Coupon Expiry',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
            }
        }

            //global usage cap
            if(!empty($coupon->total_usage_limit) && (int)$coupon->total_usage_limit > 0){
                if((int)$coupon->used_count >= (int)$coupon->total_usage_limit){
                     Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'Coupon Usage Limit Reached',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
                }
            }

            // per-user usage cap
            if(!empty($coupon->usage_limit_per_user) && (int)$coupon->usage_limit_per_user > 0){
                if(Auth::check()){
                    $userUses = DB::table('coupon_usages')
                                ->where('coupon_id', $coupon->id)
                                ->where('user_id', Auth::id())
                                ->count();
                if($userUses >= (int)$coupon->usage_limit_per_user){
                     Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'You have already used the=is coupon the maximum number of times. Please Stop!',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
                }
                }
            }

            // Get current cart and Subtotal
            $cart = $this->cartService->getCart();
            $subtotal = (float) ($cart['subtotal'] ?? 0);
            $cartQtyTotal = array_sum(array_column($cart['items'], 'qty'));

            //min / max value check
            if(!empty($coupon->min_cart_value) && $subtotal < (float)$coupon->min_cart_value){
                 Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'Cart total is less than the coupon minimum required amount',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
            }
            if(!empty($coupon->max_cart_value) && $subtotal > (float)$coupon->max_cart_value){
                 Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'Cart total is greater than the coupon maximum required amount',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
            }

            // min/max qty check
            if(!empty($coupon->min_qty) && $cartQtyTotal < (int)$coupon->min_qty){
                 Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'Cart item count is less than the coupon minimum quantity required',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
            }

            if(!empty($coupon->max_qty) && $cartQtyTotal > (int)$coupon->max_qty){
                 Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'Cart item count exceeds the coupon maximum quantity required',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
            }

            //Category applicability check
            if(!empty($couponCategories)){
                $allowedCatIds = array_map('strval', $couponCategories); //compare as string
                $matches = false;
                foreach($cart['items'] as $item){
                    $p = Product::select('id','category_id')->find($item['product_id']);
                    if($p && in_array((string)$p->category_id, $allowedCatIds, true)){
                        $matches = true;
                        break;
                    }
                }
                if(!$matches){
                     Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'Coupon not applicable to any product in the cart',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
                }
            }

            //user applicable check
            if(!empty($couponUsers)){
                if(!Auth::check()){
                     Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'You must be logged In to use this coupon.',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
                }

                $userIdOrEmail = Auth::id();
                $userEmail = Auth::user()->email ?? null;

                //normalize coupon for users for comparison(strings)
                $normalizedUsers = array_map('strval', $couponUsers);
                if(!in_array((string)$userIdOrEmail, $normalizedUsers, true) && !($userEmail && in_array($userEmail,$normalizedUsers, true))){
                     Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();
                    return [
                'status' => false,
                'message' => 'You are not eligible for this coupon.',
                 'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render(),
                'totalCartItems' => totalCartItems(),

            ];
                }
            }

            //compute discount
            $discount = 0.0;
            $amountType = strtolower((string)($coupon->amount_type ?? 'fixed'));

            if($amountType === 'percentage' || $amountType === 'percent'){
                $discount = round($subtotal * ((float)$coupon->amount / 100.0),2);
                //cap at max_discount if set
                if(!empty($coupon->max_discount) && (float)$coupon->max_discount > 0){
                    $discount = min($discount, (float)$coupon->max_discount);
                }
            }else{
                //fixed amount
                $discount = min((float)$coupon->amount,$subtotal);
            }

            //persist applied coupon to session
            Session::put('applied_coupon', $coupon->coupon_code);
            Session::put('applied_coupon_id', $coupon->id);
            Session::put('applied_coupon_discount', $discount);

            //Recompute cart fragments after setting session
            $cartAfter = $this->cartService->getCart();

            return [
                'status' => true,
                'message' => 'Coupon Applied Successfully',
                'items_html' => View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cartAfter['items']
                ])->render(),
                'summary_html' => View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cartAfter['subtotal'],
                    'discount' => $discount,
                    'total' => max(0, $cartAfter['subtotal'] - $discount),
                ])->render(),
                'totalCartItems' => totalCartItems(),
            ];

    }

    public function removeCoupon(): array
    {
        Session::forget(['applied_coupon','applied_coupon_id','applied_coupon_discount']);
                    $cart = $this->cartService->getCart();

                     $itemsHtml = View::make('front.cart.ajax_cart_items', [
                    'cartItems' => $cart['items']
                ])->render();

                $summaryHtml = View::make('front.cart.ajax_cart_summary', [
                    'subtotal' => $cart['subtotal'],
                    'discount' => 0,
                    'total' => $cart['total']
                ])->render();


                return [
                'status' => true,
                'message' => 'Coupon Removed.',
                'items_html' => $itemsHtml,
                'summary_html' => $summaryHtml,
                'totalCartItems' => totalCartItems(),


            ];
    }

}

