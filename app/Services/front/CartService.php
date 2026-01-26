<?php

namespace App\Services\front;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductsAttribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CartService
{

public function getCart(): array
{

    $rows = $this->currentCartQuery()
            ->with(['product' => function($q){
                $q->with('product_images');
            }])
            ->orderBy('id','desc')
            ->get();

    $items = [];
    $subtotal = 0;

    foreach($rows as $row){
        $product = $row->product;
        if(!$product) continue;

        // Price based on productAttribute
        $pricing = Product::getAttributePrice($product->id, $row->product_size);
        $unit = ($pricing['status'] ?? false)
                ? ($pricing['final_price'] ?? $pricing['product_price'])
                : ($product->final_price ?? $product->product_price);
        $unit = (int) $unit;

        // Image resolution
        $fallbackImage = asset('front/img/products/no-image.jpg');
        if(!empty($product->main_image)){
            $image = asset('product-image/medium/' . $product->main_image);
        }elseif(!empty($product->product_images[0]['image'])){
            $image = asset('product-image/medium/' . $product->product_images[0]['image']);
        }else{
            $image = $fallbackImage;
        }

        $lineTotal = $unit * (int)$row->product_qty;
        $subtotal += $lineTotal;

        $items[] = [
            'cart_id' => $row->id,
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'product_url' => $product->product_url,
            'image' => $image,
            'size' => $row->product_size,
            'qty' => (int) $row->product_qty,
            'unit_price' => $unit,
            'line_total' => $lineTotal,
        ];
    }

    $discount = 0;
    $total = $subtotal - $discount;

    return [
        'items' => $items,
        'subtotal' => $subtotal,
        'discount' => $discount,
        'total' => $total,
    ];
}

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

    // 4️⃣ Get session ID directly
    $session_id = session()->getId();


   //check if cart already exists
    if(Auth::check()){
        $user_id = Auth::id();
        $count= Cart::where([
            'product_id' => $data['product_id'],
            'product_size' => $data['size'],
            'user_id' => $user_id
        ])->count();
    }else{
        $user_id = 0;
        $count = Cart::where([
            'product_id' => $data['product_id'],
            'product_size' => $data['size'],
            'session_id' => $session_id
        ])->count();
    }

    if ($count > 0) {
        return ['status' => false, 'message' => 'Product already added to cart.'];
    }

    // Save to cart
    $item = new Cart();
    $item->session_id = $session_id;
    $item->user_id = $user_id;
    $item->product_id = $data['product_id'];
    $item->product_size = $data['size'];
    $item->product_qty = $data['qty'];
    $item->save();
    $cart = $this->getCart();
    $itemsHtml = View::make('front.cart.ajax_cart_items',[
        'cartItems' => $cart['items'],
    ])->render();
    $summaryHtml = View::make('front.cart.ajax_cart_summary',[
        'subtotal' => $cart['subtotal'],
        'discount' => $cart['discount'],
        'total' => $cart['total'],
    ])->render();

    return [
        'status' => true, 'message' => 'Product added to cart successfully! <a href="/cart"> View Cart</a>',
        'totalCartItems' => totalCartItems(),
        'items_html' => $itemsHtml,
        'summary_html' => $summaryHtml,
    ];
}




public function updateQty(int $cartId, int $qty): array{
    if($qty < 1){
        return ['status' => false, 'message' => 'Quantity must be at least One(1)'];
    }

    $row = $this->currentCartQuery()->where('id', $cartId)->first();
    if(!$row){
        return ['status' => false, 'message' => 'Cart item not Found!'];
    }

    $size = $row->product_size;
    if($size === 'NA'){
        $productStock = Product::where('id', $row->product_id)->value('stock') ?? 0;
    }else{
        $productStock = ProductsAttribute::productStock($row->product_id, $size);
    }

    if($qty>(int)$productStock){
        return ['status' => false, 'message' => 'Required Quantity not Available'];
    }

    $row->product_qty = $qty;
    $row->save();
    $cart = $this->getCart();
    $itemsHtml = View::make('front.cart.ajax_cart_items',[
        'cartItems' => $cart['items'],
    ])->render();
    $summaryHtml = View::make('front.cart.ajax_cart_summary',[
        'subtotal' => $cart['subtotal'],
        'discount' => $cart['discount'],
        'total' => $cart['total'],
    ])->render();

    return[
        'status' => true,
        'message' => 'Cart Added Successfully!',
        'totalCartItems' => totalCartItems(),
        'items_html' => $itemsHtml,
        'summary_html' => $summaryHtml,
        ];
}

public function removeItem(int $cartId): array{
    $deleted = $this->currentCartQuery()->where('id', $cartId)->delete();
     $cart = $this->getCart();
    $itemsHtml = View::make('front.cart.ajax_cart_items',[
        'cartItems' => $cart['items'],
    ])->render();
    $summaryHtml = View::make('front.cart.ajax_cart_summary',[
        'subtotal' => $cart['subtotal'],
        'discount' => $cart['discount'],
        'total' => $cart['total'],
    ])->render();

    return $deleted ? [
        'status' => true,
        'message' => 'Item Removed From Cart!',
        'totalCartItems' => totalCartItems(),
        'items_html' => $itemsHtml,
        'summary_html' => $summaryHtml,
        ] : ['status' => false, 'message' => 'Unable to Remove Item'];
}

protected function currentCartQuery()
{
     $session_id = session()->getId();

     $q = Cart::query();
     if(Auth::check()){
        $q->where('user_id',Auth::id());
     }else{
        $q->where('session_id',$session_id);
     }
     return $q;
}


}
