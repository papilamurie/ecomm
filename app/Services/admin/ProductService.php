<?php

namespace App\Services\admin;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\AdminsRole;
use App\Models\Category;
use App\Models\ProductsAttribute;
use App\Models\ProductsCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductService
{
    public function products(){
        $products = Product::with('category')->get();

        //Set admin/subadmin permission for products
        $productsModuleCount = AdminsRole::where([
            'subadmin_id' => Auth::guard('admin')->user()->id,
            'module' => 'products'
        ])->count();
        $status = "success";
        $message = "";
        $productsModule = [];
        if(Auth::guard('admin')->user()->role=="admin"){
            $productsModule=[
                'view_access'=>1,
                'edit_access'=>1,
                'full_access'=>1
            ];
        }elseif($productsModuleCount==0){
            $status = "error";
            $message= "This feature is not for you!";
        }else{
            $productsModule=AdminsRole::where([
                'subadmin_id'=>Auth::guard('admin')->user()->id,
                'module'=>'products'
            ])->first()->toArray();
        }
        return[
            "products" => $products,
            "productsModule"=> $productsModule,
            "status"=> $status,
            "message" => $message
        ];
    }

public function addEditProduct($request)
{
    $data = $request->all();
    $isEdit = !empty($data['id']);

    // -------------------------
    // Add or Edit Product
    // -------------------------
    if ($isEdit) {
        $product = Product::findOrFail($data['id']);
        $message = 'Product updated successfully!';
    } else {
        $product = new Product();
        $message = 'Product added successfully!';
    }

    // -------------------------
    // Basic Product Fields
    // -------------------------
    $product->admin_id       = Auth::guard('admin')->user()->id;
    $product->admin_type     = Auth::guard('admin')->user()->role;
    $product->category_id    = $data['category_id'];
    $product->brand_id       = $data['brand_id'];
    $product->product_name   = $data['product_name'];
    $product->product_code   = $data['product_code'];
    $product->product_color  = $data['product_color'];
    $product->family_color   = $data['family_color'];
    $product->group_code     = $data['group_code'];
    $product->product_weight = $data['product_weight'] ?? 0;
    $product->product_price  = $data['product_price'];
    $product->product_gst    = $data['product_gst'] ?? 0;
    $product->product_discount = $data['product_discount'] ?? 0;
    $product->is_featured    = $data['is_featured'] ?? 'No';

    // -------------------------
    // Discount Calculation
    // -------------------------
    if (!empty($data['product_discount']) && $data['product_discount'] > 0) {
        $product->discount_applied_on = 'product';
        $product->product_discount_amount = ($data['product_price'] * $data['product_discount']) / 100;
    } else {
        $categoryDiscount = Category::select('discount')->where('id', $data['category_id'])->first();
        if ($categoryDiscount && $categoryDiscount->discount > 0) {
            $product->discount_applied_on = 'category';
            $product->product_discount = $categoryDiscount->discount;
            $product->product_discount_amount = ($data['product_price'] * $categoryDiscount->discount) / 100;
        } else {
            $product->discount_applied_on = '';
            $product->product_discount_amount = 0;
        }
    }

    $product->final_price = $data['product_price'] - $product->product_discount_amount;

    $product->description      = $data['description'] ?? '';
    $product->wash_care        = $data['wash_care'] ?? '';
    $product->search_keywords  = $data['search_keywords'] ?? '';
    $product->meta_title       = $data['meta_title'] ?? '';
    $product->meta_description = $data['meta_description'] ?? '';
    $product->meta_keywords    = $data['meta_keywords'] ?? '';
    $product->status           = 1;

    $product->save();

    // sync other categories
    if(!empty($data['other_categories']) && is_array($data['other_categories'])){
        //clear records
        ProductsCategory::where('product_id', $product->id)->delete();

        //insert new records
        foreach($data['other_categories'] as $catId){
            ProductsCategory::create([
                'product_id'  => $product->id,
                'category_id' => $catId
            ]);
        }
    }
        else{
            //clear records
            ProductsCategory::where('product_id', $product->id)->delete();
        }


    //sync filter values
    if(!empty($data['filter_values']) && is_array($data['filter_values'])){
       // data['filter_values'] = [filter_id=> filter_value_id, ...]
       // keep only selected values (non-empty)
       $values = array_values(array_filter($data['filter_values']));
       $product->filterValues()->sync($values);
    }else{
        $product->filterValues()->detach();
    }

    // -------------------------
    // Main Image Handling
    // -------------------------
    if (!empty($data['main_image'])) {
        if ($isEdit && !empty($product->main_image)) {
            $mainImagePath = public_path('front/img/products/' . $product->main_image);
            $thumbPath = public_path('product-image/thumbnail/' . $product->main_image);
            if (file_exists($mainImagePath)) unlink($mainImagePath);
            if (file_exists($thumbPath)) unlink($thumbPath);
        }
        $product->main_image = $data['main_image'];
        $product->save();
    }

    // -------------------------
    // Product Video Handling
    // -------------------------
    if (!empty($data['product_video'])) {
        if ($isEdit && !empty($product->product_video)) {
            $videoPath = public_path('front/videos/products/' . $product->product_video);
            if (file_exists($videoPath)) unlink($videoPath);
        }
        $product->product_video = $data['product_video'];
        $product->save();
    }

    // -------------------------
    // Gallery Images Handling
    // -------------------------
    if (!empty($data['product_images'])) {
        $newImages = array_filter(explode(',', $data['product_images']));

        if ($isEdit) {
            $oldImages = $product->product_images()->get();
            foreach ($oldImages as $img) {
                $imgPath = public_path('front/img/products/' . $img->image);
                if (file_exists($imgPath)) unlink($imgPath);
            }

            ProductImage::where('product_id', $product->id)->delete();
        }

        foreach ($newImages as $imgName) {
            ProductImage::create([
                'product_id' => $product->id,
                'image'      => $imgName,
                'sort'       => 0,
                'status'     => 1,
            ]);
        }
    }

    // -------------------------
    // Product Attributes
    // -------------------------
 $total_stock = 0;

// -------------------------
// Add New Attributes
// -------------------------
if(!empty($data['sku'])){
    foreach($data['sku'] as $key => $value){
        if(empty($value) || empty($data['size'][$key]) || empty($data['price'][$key])) continue;

        // Check duplicate SKU
        $attrCountSku = ProductsAttribute::where('sku', $value)->count();
        if($attrCountSku > 0){
            return [
                'status'  => 'error',
                'message' => "SKU '{$value}' already exists. Please choose another SKU."
            ];
        }

        // Check duplicate size for the same product
        $attrCountSize = ProductsAttribute::where([
            'product_id' => $product->id,
            'size'       => $data['size'][$key]
        ])->count();
        if($attrCountSize > 0){
            return [
                'status'  => 'error',
                'message' => "Size '{$data['size'][$key]}' already exists for this product!"
            ];
        }

        $stock = $data['stock'][$key] ?? 0;

        ProductsAttribute::create([
            'product_id' => $product->id,
            'sku'        => $value,
            'size'       => $data['size'][$key],
            'price'      => $data['price'][$key],
            'stock'      => $stock,
            'sort'       => $data['sort'][$key] ?? 0,
            'status'     => 1
        ]);

        $total_stock += $stock;
    }
}

// -------------------------
// Update Existing Attributes
// -------------------------
if(!empty($data['attrId'])){
    foreach($data['attrId'] as $key => $attrId){
        if(empty($attrId)) continue;

        ProductsAttribute::where('id', $attrId)->update([
            'price' => $data['update_price'][$key],
            'stock' => $data['update_stock'][$key],
            'sort'  => $data['update_sort'][$key] ?? 0
        ]);
    }

    // Recalculate total stock after updates
    $total_stock = ProductsAttribute::where('product_id', $product->id)->sum('stock');
}

// -------------------------
// Update total stock in products table
// -------------------------
$product->update(['stock' => $total_stock]);

return [
    'status'  => 'success',
    'message' => $message
];
}




    public function updateProductStatus($data){
    $status = ($data['status'] == 'Active') ? 0 : 1;

    Product::where('id', $data['product_id'])->update(['status' => $status]);

    return $status;
}

public function updateAttributeStatus($data){
    $status = ($data['status'] == 'Active') ? 0 : 1;

   ProductsAttribute::where('id', $data['attribute_id'])->update(['status' => $status]);

    return $status;
}

public function DeleteProductAttribute($id){
    //delete Category
    ProductsAttribute::where('id', $id)->delete();
    $message = ' Product Attribute deleted successfully!';
    return array("message" =>$message);
}

public function DeleteProduct($id){
    // Get product
    $product = Product::findOrFail($id);

    $productPath = public_path('front/img/products/');

    // 1. Get gallery images
    $productsAttr = ProductsAttribute::where('product_id', $product->id)->get();

    // 1. Get gallery images
    $galleryImages = ProductImage::where('product_id', $product->id)->get();

    // 2. Delete gallery image files
    foreach ($galleryImages as $image) {
        $imagePath = $productPath . $image->image;

        if (!empty($image->image) && File::exists($imagePath)) {
            File::delete($imagePath);
        }
    }

    // 3. Delete main image
    if (!empty($product->main_image)) {
        $mainImagePath = $productPath . $product->main_image;

        if (File::exists($mainImagePath)) {
            File::delete($mainImagePath);
        }
    }

    if(!empty($productsAttr)){

    ProductsAttribute::where('product_id', $product->id)->delete();
    }

    // 4. Delete gallery image records
    ProductImage::where('product_id', $product->id)->delete();

    // 5. Delete product record
    $product->delete();

    return ['message' => 'Product deleted successfully!'];
}

public function handleImageUpload($file){
    $imageName = time(). '.' . rand(1111,9999) . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('front/img/products'),$imageName);
    return $imageName;
}

public function handleVideoUpload($file){
    $videoName = time().'.'.$file->getClientOriginalExtension();
    $file->move(public_path('front/videos/products'),$videoName);
    return $videoName;
}

public function deleteProductMainImage($id)
{
    $product = Product::select('main_image')->where('id', $id)->first();

    if (!$product || !$product->main_image) {
        return [
            'status' => false,
            'message' => 'No product image found.'
        ];
    }

    $image_path = public_path('front/img/products/' . $product->main_image);

    if (file_exists($image_path)) {
        unlink($image_path);
    }

    Product::where('id', $id)->update(['main_image' => null]);

    return [
        'status' => true,
        'message' => 'Product main image deleted successfully!'
    ];
}

public function deleteDropzoneImage(string $imageName): bool {
    $imagePath = public_path('front/img/products/' .$imageName);
    return file_exists($imagePath) ? unlink($imagePath) : false;
}

public function deleteDropzoneVideo(string $videoName): bool {
    $videoPath = public_path('front/videos/products/' .$videoName);
    return file_exists($videoPath) ? unlink($videoPath) : false;
}

public function deleteProductImages($id)
{
    $product = ProductImage::select('image')->where('id', $id)->first();

    if (!$product || !$product->image) {
        return [
            'status' => false,
            'message' => 'No product image found.'
        ];
    }

    $image_path = public_path('front/img/products/' . $product->image);

    if (file_exists($image_path)) {
        unlink($image_path);
    }

    ProductImage::where('id', $id)->delete();

    return [
        'status' => true,
        'message' => 'Product image deleted successfully!'
    ];
}


public function deleteProductVideo($id){
    //get main image
    $product = Product::select('product_video')->where('id', $id)->first();
    if(!$product || !$product->product_video){
        return 'No Video Found';
    }

    //get Video path
    $video_path = public_path('front/videos/products/'.$product->product_video);

    //delete video if exists
    if(file_exists($video_path)){
        unlink($video_path);
    }

    //delete main Video
    Product::where('id',$id)->update(['product_video'=>null]);
$message = 'Product Video has been deleted successfully!';
return $message;
}

public function updateImageSorting(array $sortedImages):void{
    foreach($sortedImages as $imageData){
        if(isset($imageData['id'])&&isset($imageData['sort'])){
            ProductImage::where('id',$imageData['id'])->update([
                'sort' => $imageData['sort']
            ]);
        }
    }
}

}
