<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
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

    public function ajaxSearch(Request $request)
    {
        $query = trim($request->get('q'));
        if(strlen($query) < 3) {
            return '';
        }
        $usedAlgolia =false;
        //step 1. DB Search
        $products = $this->productService->searchProducts($query, 6);
        //step 2. Algolia Search if no results from DB
        if($products->isEmpty()){
            $isAlgoliaConfigured = config('scout.driver') === 'algolia' &&
            !empty(config('scout.algolia.id')) &&
            !empty(config('scout.algolia.secret'));
            if($isAlgoliaConfigured){
                $products = Product::search($query)->take(6)->get();
                $usedAlgolia = true;
            }

            }
        //step 3. Prepare HTML output
        $output = '';
        foreach($products as $product){
            //get product image
            if(!empty($product->main_image)){
                $image = asset('front/img/products/' . $product->main_image);
            }elseif(!empty($product->product_images) && $product->product_images->isNotEmpty()){
                $image = asset('front/img/products/' . $product->product_images->first()->image);
            }else{
                $image = asset('front/img/products/no-image.png');
            }

            $output .= '
                                <div class="search-result-item py-2 border-bottom w-100">
                                    <div class="row align-items-center gx-2">

                                        <!-- Image -->
                                        <div class="col-auto">
                                            <a href="' . url('product/' . $product->id) . '">
                                                <img src="' . $image . '"
                                                    alt="' . e($product->product_name) . '"
                                                    class="img-fluid"
                                                    style="width:60px;height:60px;object-fit:cover;border-radius:5px;">
                                            </a>
                                        </div>

                                        <!-- Product Info -->
                                        <div class="col overflow-hidden">
                                            <h6 class="mb-1 text-truncate" style="font-size:14px;">
                                                ' . e($product->product_name) . '
                                            </h6>

                                            <div class="d-flex align-items-center flex-wrap">
                                                <span class="text-primary fw-bold">
                                                    $' . number_format($product->product_price, 2) . '
                                                </span>';

                                                if ($product->product_discount > 0) {
                                                    $output .= '
                                                    <small class="text-muted ms-2">
                                                        <del>$' . number_format($product->product_price, 2) . '</del>
                                                    </small>';
                                                }

                                $output .= '
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="col-auto text-end">
                                            <a href="' . url('product/' . $product->id) . '"
                                            class="btn btn-sm btn-outline-primary me-1"
                                            title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                            data-id="' . $product->id . '"
                                            class="btn btn-sm btn-outline-success addToCartBtn"
                                            title="Add to Cart">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>';


        }
        // Algolia badge
        if($usedAlgolia && $products->count()){
            $output .= '<div class="text-right mt-2">
                     <a href="https://www.algolia.com/" target="_blank" rel="noopener">
                     <img src="/front/img/algolia.png" alt="Search by Algolia" style="height:20px;">
                     </a>
                     </div>';
    }
        return $output ?: '<div align="center">No Results Found</div>';
}

}
