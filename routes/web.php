<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Capsule\Manager;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Response;

//Admin Controllers
use App\Http\Controllers\admin\Admincontroller;
use App\Http\Controllers\admin\BrandController;
use App\Models\Category;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\BannersController;
use App\Http\Controllers\admin\FilterController;
use App\Http\Controllers\admin\FilterValueController;
use App\Http\Controllers\front\CartController;
//Front Controllers
use App\Http\Controllers\front\IndexController;
use App\Http\Controllers\front\ProductController as ProductFrontController;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('product-image/{size}/{filename}', function ($size, $filename){
    $sizes = config('image_sizes.product');
    if(!isset($sizes[$size])){
        abort(404, 'Invalid Size');
    }
    $width = $sizes[$size]['width'];
    $height = $sizes[$size]['height'];
    $path = public_path('front/img/products/' . $filename);
    if(!file_exists($path)){
        abort(404, 'Image not Found!');
    }
    $manager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
    $image = $manager->read($path)->resize($width, $height, function ($constraint){
        $constraint->aspectRatio();
        $constraint->upsize();
    });
    $binary = $image->toJpeg(85);
    return Response::make($binary)->header('Content-Type', 'image/jpeg');
});

Route::prefix('admin')->group(function(){
        //show login
 Route::get('login', [Admincontroller::class, 'create'])->name('admin.login');
        // submit login form

Route::post('login',[Admincontroller::class, 'store'])->name('admin.login.request');
        //dashboard route
 Route::group(['middleware' => ['admin']], function(){
    Route::resource('dashboard', AdminController::class)->only(['index']);
 });
            // Show Password route
       Route::get('update-password', [AdminController::class, 'edit'])->name('admin.update-password');

            // Verifying password Route
       Route::post('verify-password',[Admincontroller::class, 'verifyPassword'])->name('admin.verify.password');

            // update Password
        Route::post('admin/update-password',[Admincontroller::class, 'updatePasswordRequest'])
        ->name('admin.update-password.request');

            // logout route
   Route::get('logout', [AdminController::class, 'destroy'])->name('admin.logout');

            // Display Update admin details
   Route::get('update-details', [AdminController::class, 'editDetails'])->name('admin.update-details');

                // Delete Profile Image route
      Route::post('delete-profile-image', [Admincontroller::class, 'deleteProfileImage']);

    // update details route
        Route::post('update-details',[Admincontroller::class, 'updateDetails'])
        ->name('admin.update-details.request');

       // Subadmins Route
       Route::get('subadmins', [Admincontroller::class, 'subadmins']);

       // Update Subadmin Route
    Route::post('update-subadmin-status', [Admincontroller::class, 'updateSubadminStatus']);
    Route::get('delete-subadmin/{id}', [Admincontroller::class, 'DeleteSubadmin']);
    Route::post('add-edit-subadmin',   [AdminController::class, 'addEditSubadminRequest']
)->name('admin.add-edit-subadmin.request');
    Route::get('add-edit-subadmin/{id?}', [Admincontroller::class, 'addEditSubadmin']
)->name('admin.add-edit-subadmin.request');

Route::get('/update-role/{id}', [Admincontroller::class, 'updateRole']);
Route::post('/update-role/request', [Admincontroller::class, 'updateRoleRequest']);


                    // Admin Categories

  Route::resource('categories', CategoryController::class);
 Route::post('update-category-status', [CategoryController::class, 'updateCategoryStatus']);
  Route::get('delete-category/{id}', [CategoryController::class, 'DeleteCategory']);
   // Delete Category Image route
     Route::post('delete-category-image', [CategoryController::class, 'deleteCategoryImage'])
     ->name('category.image.delete');
     // Delete SizeChart Image route
     Route::post('delete-sizechart-image', [CategoryController::class, 'deleteSizechartImage'])
     ->name('sizechart.image.delete');

                //Products Route
 Route::get('delete-product-main-image/{id}', [ProductController::class, 'deleteProductMainImage']
);

Route::get('delete-product-video/{id}', [ProductController::class, 'deleteProductVideo']
);
    Route::resource('products', ProductController::class);
    Route::post('update-product-status', [ProductController::class, 'updateProductStatus']);
    Route::post('update-attribute-status', [ProductController::class, 'updateAttributeStatus']);
    Route::get('delete-product-attribute/{id}', [ProductController::class, 'DeleteProductAttribute']);
    Route::get('delete-product/{id}', [ProductController::class, 'DeleteProduct']);
    Route::get('delete-product-images/{id}', [ProductController::class, 'DeleteProductImages']);
    Route::post('/product/upload-image', [ProductController::class, 'uploadImage'])
     ->name('product.upload.image');
    Route::post('/product/update-image-sorting', [ProductController::class, 'updateImageSorting'])
    ->name('admin.products.update-image-sorting');
    Route::post('/product/upload-images', [ProductController::class, 'uploadImages'])
     ->name('product.upload.images');
    Route::post('/product/delete-temp-images', [ProductController::class, 'deleteTempImages'])
     ->name('product.delete.temp.images');
    Route::post('/product/delete-temp-image', [ProductController::class, 'deleteTempProductImage'])
    ->name('product.delete.temp.altimages');
    Route::post('/product/delete-temp-video', [ProductController::class, 'deleteTempProductVideo'])
    ->name('product.delete.temp.video');
    Route::post('/product/delete-dropzone-image', [ProductController::class, 'deleteDropzoneImage'])
     ->name('product.delete-image');

    Route::post('/product/upload-video', [ProductController::class, 'uploadVideo'])
     ->name('product.upload.video');


        //Filters CRUD + Status Update
    Route::resource('filters', FilterController::class);
    Route::post('update-filter-status', [FilterController::class, 'updateFilterStatus'])->name('filters.updateStatus');

        // Filter Values CRUD (Nested inside filters)
    Route::prefix('filter/{filter}')->group(function (){
        Route::resource('filter_values', FilterValueController::class)->parameters(['filter_values' => 'value']);

    });


    // Route::post('/save-column-order', [Admincontroller::class, 'saveColumnOrder']);
    Route::post('/save-column-visibility', [AdminController::class, 'saveColumnVisibility']);



    //Brand Routes
     Route::resource('brands', BrandController::class);
     Route::post('update-brand-status', [BrandController::class, 'updateBrandStatus']);
     Route::get('delete-brands/{id}', [ProductController::class, 'DeleteBrand']);


    //Banners Routes
     Route::resource('banners', BannersController::class);
     Route::post('update-banner-status', [BannersController::class, 'updateBannerStatus']);
});

Route::middleware('web')->namespace('App\Http\Controllers\front')->group(function (){
    Route::get('/', [IndexController::class, 'index']);

    //Category view route for products
    $catUrls = Category::where('status', 1)->pluck('url')->toArray();
    foreach($catUrls as $url){
        Route::get("/$url", [ProductFrontController::class, 'index']);
    }

    // product detail route
    if(Schema::hasTable('products')){
        try{
            $productUrls = Product::where('status', 1)->pluck('product_url')->toArray();
            foreach($productUrls as $url){
                Route::get("/$url", [ProductFrontController::class, 'detail']);
            }
        }catch(\Throwable $e){
            // ignore errors during migration
        }
    }

    Route::post('/get-product-price', [ProductFrontController::class, 'getProductPrice']);

    // search route
    Route::get('/search-products', [ProductFrontController::class, 'ajaxSearch'])->name('search.products');

    // Cart routes - SPECIFIC routes MUST come BEFORE general routes
    Route::get('/cart/refresh', [CartController::class, 'refresh'])->name('cart.refresh');  // ✅ Moved before /cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');  // ✅ Changed from /add-to-cart
    Route::patch('/cart/{cartId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartId}', [CartController::class, 'destroy'])->name('cart.destroy');
});
