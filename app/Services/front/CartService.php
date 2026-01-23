<?php

namespace App\Services\front;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductsAttribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
public function addToCart($data)
{
    // 1️⃣ Extra safety validation (server-side)
    if (empty($data['product_id']) || empty($data['size']) || empty($data['qty'])) {
        return [
            'status' => false,
            'message' => 'Product, size, and quantity are required.'
        ];
    }

    // 2️⃣ Check stock
    $stock = ProductsAttribute::productStock($data['product_id'], $data['size']);
    if ((int)$data['qty'] > $stock) {
        return ['status' => false, 'message' => 'Required quantity is not available.'];
    }

    // 3️⃣ Check product status
    if (Product::productStatus($data['product_id']) == 0) {
        return ['status' => false, 'message' => 'Product is not available!'];
    }

    // 4️⃣ Ensure session_id exists and persists
    $session_id = Session::get('session_id');
    if (!$session_id) {
        $session_id = Session::getId();
        Session::put('session_id', $session_id);
    }

    // 5️⃣ Determine user_id
    $user_id = Auth::check() ? Auth::id() : 0;

    // 6️⃣ Check if already in cart
    $exists = Cart::where('product_id', $data['product_id'])
                  ->where('product_size', $data['size'])
                  ->when($user_id, fn($q) => $q->where('user_id', $user_id))
                  ->when(!$user_id, fn($q) => $q->where('session_id', $session_id))
                  ->exists();

    if ($exists) {
        return ['status' => false, 'message' => 'Product already added to cart.'];
    }

    // 7️⃣ Save to cart
    Cart::create([
        'session_id'    => $session_id,
        'user_id'       => $user_id,
        'product_id'    => $data['product_id'],
        'product_size'  => $data['size'],
        'product_qty'   => (int)$data['qty'],
    ]);

    return ['status' => true, 'message' => 'Product added to cart successfully! <a href="/cart">View Cart</a>'];
}


}
