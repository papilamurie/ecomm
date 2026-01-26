<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CartRequest;
use App\Services\front\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
   protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService =$cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
{


    return view('front.cart.index');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request)
    {
        $data = $request->validated();
        $result = $this->cartService->addToCart($data);
        return response()->json($result, $result['status'] ? 200 : 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    //Get /cart/refresh (Ajax fragments)
    public function refresh()
    {
        $cart = $this->cartService->getCart();
        $itemsHtml = View::make('front.cart.ajax_cart_items', [
            'cartItems' => $cart['items'],
        ])->render();
        $summaryHtml = View::make('front.cart.ajax_cart_summary', [
            'subtotal' => $cart['subtotal'],
            'discount' => $cart['discount'],
            'total' => $cart['total'],
        ])->render();
        return response()->json([
            'items_html' => $itemsHtml,
            'summary_html' => $summaryHtml,
            'totalCartItems' => totalCartItems(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CartRequest $request, $cartId)
    {
        $data = $request->validated();
        $result = $this->cartService->updateQty((int)$cartId, (int)$data['qty']);
        return response()->json($result, $result['status'] ? 200 : 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cartId)
    {
        $result = $this->cartService->removeItem((int)$cartId);
         return response()->json($result, $result['status'] ? 200 : 422);
    }
}
