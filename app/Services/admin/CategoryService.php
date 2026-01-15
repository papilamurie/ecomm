<?php

namespace App\Services\admin;

use App\Models\Category;
use App\Models\AdminsRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryService
{
    /**
     * Fetch all categories with admin role validation
     */
    public function categories()
    {
        $categories = Category::with('parentcategory')->get();
        $admin = Auth::guard('admin')->user();

        $status = "success";
        $message = "";
        $categoriesModule = [];

        // If admin → full access
        if ($admin->role == "admin") {
            $categoriesModule = [
                'view_access' => 1,
                'edit_access' => 1,
                'full_access' => 1
            ];
        } else {
            // Subadmin permissions
            $role = AdminsRole::where([
                'subadmin_id' => $admin->id,
                'module' => 'categories'
            ])->first();

            if (!$role) {
                return [
                    "categories" => [],
                    "categoriesModule" => [],
                    "status" => "error",
                    "message" => "This feature is not available for your role!"
                ];
            }

            $categoriesModule = $role->toArray();
        }

        return [
            "categories" => $categories,
            "categoriesModule" => $categoriesModule,
            "status" => $status,
            "message" => $message
        ];
    }

    /**
     * Add or Edit a Category
     */
    public function addEditCategory($request)
    {
        $data = $request->all();

        /*
        |--------------------------------------------------------------------------
        | Check if Add or Edit
        |--------------------------------------------------------------------------
        */
        if (!empty($data['id'])) {
            $category = Category::findOrFail($data['id']);
            $message = "Category updated successfully!";
        } else {
            $category = new Category();
            $message = "Category added successfully!";
        }

        /*
        |--------------------------------------------------------------------------
        | Parent ID
        |--------------------------------------------------------------------------
        | 0 = main category
        */
        $category->parent_id = $data['parent_id'] ?? 0;

        /*
        |--------------------------------------------------------------------------
        | Upload Category Image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('category_image') && $request->file('category_image')->isValid()) {
            $category->image = $this->uploadImage(
                $request->file('category_image'),
                'front/img/categories/'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Size Chart
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('size_chart') && $request->file('size_chart')->isValid()) {
            $category->size_chart = $this->uploadImage(
                $request->file('size_chart'),
                'front/img/sizecharts/'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Format Name & URL
        |--------------------------------------------------------------------------
        */
        $data['category_name'] = ucwords(strtolower(str_replace("-", " ", $data['category_name'])));
        $data['url'] = strtolower(str_replace(" ", "-", $data['url']));

        $category->name = $data['category_name'];
        $category->url = $data['url'];

        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */
        $category->discount = $data['category_discount'] ?: 0;

        /*
        |--------------------------------------------------------------------------
        | Meta Fields
        |--------------------------------------------------------------------------
        */
        $category->description       = $data['description'];
        $category->meta_title        = $data['meta_title'];
        $category->meta_description  = $data['meta_description'];
        $category->meta_keywords     = $data['meta_keywords'];

        /*
        |--------------------------------------------------------------------------
        | Menu Status
        |--------------------------------------------------------------------------
        */
        $category->menu_status = !empty($data['menu_status']) ? 1 : 0;

        /*
        |--------------------------------------------------------------------------
        | Default Status
        |--------------------------------------------------------------------------
        */
        $category->status = 1;

        $category->save();

        return $message;
    }

    /**
     * Upload Image Helper
     */
    private function uploadImage($file, $directory)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);

        $extension = $file->getClientOriginalExtension();
        $filename = rand(111, 99999) . '.' . $extension;

        $path = public_path($directory . $filename);

        // Ensure directory exists
        if (!file_exists(public_path($directory))) {
            mkdir(public_path($directory), 0777, true);
        }

        // Save image
        $image->save($path);

        return $filename;
    }

   public function updateCategoryStatus($data){
    $status = ($data['status'] == 'Active') ? 0 : 1;

    Category::where('id', $data['category_id'])->update(['status' => $status]);

    return $status;
}

public function DeleteCategory($id){
     // Get Category first
    $category = Category::findOrFail($id);

    // Delete image from folder if exists
    $categoryPath = public_path('front/img/categories/' . $category->image);
    if (!empty($category->image) && File::exists($categoryPath)) {
        File::delete($categoryPath);
    }

    // Delete record from database
    $category->delete();

    return [
        'message' => 'Category deleted successfully!'
    ];
}
public function deleteCategoryImageService($category_id)
{
    // Step 1: Fetch the category record
    $category = Category::find($category_id);

    if (!$category) {
        return [
            'status' => false,
            'message' => 'Category not found for ID: ' . $category_id
        ];
    }

    // Step 2: Get the image filename
    $categoryImage = $category->image;

    if (!$categoryImage) {
        return [
            'status' => false,
            'message' => 'No image found in the database for this category!'
        ];
    }

    // Step 3: Build the full path
    $path = public_path('front/img/categories/' . ltrim($categoryImage, '/'));

    // Step 4: Check if file exists
    if (!file_exists($path)) {
        return [
            'status' => false,
            'message' => "Image file not found at path: $path"
        ];
    }

    // Step 5: Delete the file
    try {
        unlink($path);
    } catch (\Exception $e) {
        return [
            'status' => false,
            'message' => 'Failed to delete image: ' . $e->getMessage()
        ];
    }

    // Step 6: Update the database
    $category->image = null;
    $category->save();

    return [
        'status' => true,
        'message' => 'Category image deleted successfully!'
    ];
}

public function deleteSizechartImageService($category_id)
{
    // Step 1: Fetch the category record
    $category = Category::find($category_id);

    if (!$category) {
        return [
            'status' => false,
            'message' => 'Sizechart not found for ID: ' . $category_id
        ];
    }

    // Step 2: Get the image filename
    $sizechartImage = $category->size_chart;

    if (!$sizechartImage) {
        return [
            'status' => false,
            'message' => 'No image found in the database for this sizechart!'
        ];
    }

    // Step 3: Build the full path
    $path = public_path('front/img/sizecharts/' . ltrim($sizechartImage, '/'));

    // Step 4: Check if file exists
    if (!file_exists($path)) {
        return [
            'status' => false,
            'message' => "Image file not found at path: $path"
        ];
    }

    // Step 5: Delete the file
    try {
        unlink($path);
    } catch (\Exception $e) {
        return [
            'status' => false,
            'message' => 'Failed to delete image: ' . $e->getMessage()
        ];
    }

    // Step 6: Update the database
    $category->size_chart = null;
    $category->save();

    return [
        'status' => true,
        'message' => 'Sizechart image deleted successfully!'
    ];
}


}
