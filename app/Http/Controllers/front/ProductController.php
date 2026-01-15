<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Services\front\ProductService;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService =$productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = Route::current()->uri();
        $category = Category::where('url', $url)->where('status', 1)->first();
        if(!$category){
            abort(404);
        }
        $data = $this->productService->getCategoryListingData($url);

        //if ajax call(filter.js)
        if(request()->has('json')){
            $view = view('front.products.ajax_products_listing', $data)->render();
            return response()->json(['view' => $view]);
        }

        return view('front.products.index', $data);
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
    public function store(Request $request)
    {
        //
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
