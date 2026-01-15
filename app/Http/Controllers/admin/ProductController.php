<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ProductRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Services\admin\ProductService;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\ColumnPreference;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    Session::put('page', 'products');

    $result = $this->productService->products();

    if ($result['status'] === 'error') {
        return redirect('admin/dashboard')
            ->with('error_message', $result['message']);
    }

    $products = $result['products'];
    $productsModule = $result['productsModule'];

    // Get saved column preferences
    $columnPrefs = ColumnPreference::where('admin_id', Auth::guard('admin')->id())
        ->where('table_name','products')
        ->first();

    $productsSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
    $productsHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];

    return view('admin.products.index', compact(
        'products',
        'productsModule',
        'productsSaveOrder',
        'productsHiddenCols'
    ));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Product';

        // Fetch nested categories for dropdown
        $getCategories = Category::getCategories('Admin');
        // Fetch active Brands
        $brands = Brand::where('status',1)->get()->toArray();

        return view('admin.products.add_edit_product', compact(
            'title',
            'getCategories',
            'brands'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(ProductRequest $request)
    {
        $result = $this->productService->addEditProduct($request);

        if ($result['status'] === 'error') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error_message', $result['message']);
        }

        return redirect()
            ->route('products.index')
            ->with('success_message', $result['message']);
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
        $title = "Edit Product";
        $product = Product::with(['product_images','attributes'])->findOrFail($id);

        $getCategories = Category::getCategories('Admin');

         $brands = Brand::where('status',1)->get()->toArray();

        return view('admin.products.add_edit_product', compact(
            'title',
            'product',
            'getCategories',
            'brands'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $request->merge(['id' => $id]);

        $result = $this->productService->addEditProduct($request);

        if ($result['status'] === 'error') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error_message', $result['message']);
        }

        return redirect()
            ->route('products.index')
            ->with('success_message', $result['message']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->productService->DeleteProduct($id);
        return redirect()->back()->with('success_message', $result['message']);
    }

    public function updateProductStatus(Request $request){
    if($request->ajax()){
        $data = $request->all();
        $status = $this->productService->updateProductStatus($data);
        return response()->json(['status'=> $status]);
    }
}

public function updateAttributeStatus(Request $request){
    if($request->ajax()){
        $data = $request->all();
        $status = $this->productService->updateAttributeStatus($data);
        return response()->json(['status'=> $status]);
    }
}

 public function deleteProductAttribute($id)
{
     $result = $this->productService->deleteProductAttribute($id);
    return redirect()->back()->with('success_message', $result['message']);
}

    public function uploadImage(Request $request)
    {
        if($request->hasFile('file')){
            $fileName = $this->productService->handleImageUpload($request->file('file'));
            return response()->json(['fileName' => $fileName]);
        }
        return response()->json(['error'=>'No file uploaded'],400);
    }

   public function uploadVideo(Request $request)
    {
        if($request->hasFile('file')){
           $fileName = $this->productService->handleVideoUpload($request->file('file'));
            return response()->json(['fileName' => $fileName]);
        }
        return response()->json(['error'=>'No file uploaded'],400);
    }

   public function deleteProductMainImage($id)
{
    $response = $this->productService->deleteProductMainImage($id);

    if ($response['status']) {
        return redirect()->back()->with('success_message', $response['message']);
    }

    return redirect()->back()->with('error_message', $response['message']);
}

    public function deleteProductVideo($id)
    {

           $message = $this->productService->deleteProductVideo($id);
            return redirect()->back()->with('success_message',$message);


    }

   public function uploadImages(Request $request)
    {
        if($request->hasFile('file')){
            $fileName = $this->productService->handleImageUpload($request->file('file'));
            return response()->json(['fileName' => $fileName]);
        }
        $file = $request->file('file');
        $file->move(public_path('temp'), $file);
        return response()->json(['fileName'=>$file,'success'=>true]);
    }

    public function deleteProductImages($id)
{
    $response = $this->productService->deleteProductImages($id);

    if ($response['status']) {
        return redirect()->back()->with('success_message', $response['message']);
    }

    return redirect()->back()->with('error_message', $response['message']);
}

public function deleteDropzoneImage(Request $request){
    $deleted = $this->productService->deleteDropzoneImage($request->image);
    return response()->json(['status' => $deleted ? 'deleted' : 'file_not_found'], $deleted ? 200 : 404);
}

public function deleteTempProductImage(Request $request){
    $deleted = $this->productService->deleteDropzoneImage($request->filename);
    return response()->json(['status' => $deleted ? 'deleted' : 'file_not_found'], $deleted ? 200 : 404);
}

public function deleteTempProductVideo(Request $request){
    $deleted = $this->productService->deleteDropzoneVideo($request->filename);
    return response()->json(['status' => $deleted ? 'deleted' : 'file_not_found'], $deleted ? 200 : 404);
}

public function updateImageSorting(Request $request){
    $this->productService->updateImageSorting($request->sorted_images);
    return response()->json(['status' => 'success']);
}


}
