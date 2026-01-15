<?php

namespace App\Services\admin;

use App\Models\Brand;
use App\Models\AdminsRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BrandService
{
     public function brands()
    {
        $brands = Brand::get();
        $admin = Auth::guard('admin')->user();
        $status = "success";
        $message = "";
        $brandsModule = [];

        // If admin → full access
        if ($admin->role == "admin") {
            $brandsModule = [
                'view_access' => 1,
                'edit_access' => 1,
                'full_access' => 1
            ];
        } else {
            // Subadmin permissions
            $brandsModuleCount = AdminsRole::where([
                'subadmin_id' => $admin->id,
                'module' => 'brands'
            ])->count();

            if($brandsModuleCount == 0){
                $status = 'error';
                $message = 'This feature is not available for your role!';
            }else{
                $brandsModule = AdminsRole::where([
                    'subadmin_id' => $admin->id,
                    'module'=>'brands'
                ])->first()->toArray();
            }
         }

        return [
            "brands" => $brands,
            "brandsModule" => $brandsModule,
            "status" => $status,
            "message" => $message
        ];
    }

    public function addEditBrand($request){
        $data = $request->all();
        if(isset($data['id']) && $data['id'] !=""){
            //Edit Brand
            $brand = Brand::find($data['id']);
            $message = "Brand Updated Successfully!";
        }else{
            //ADD Brand
            $brand = new Brand;
            $message = "Brand Added successfully!";
        }

        //Upload Brand Image
        if($request->hasFile('image')){
            $image_tmp = $request->file('image');
            if($image_tmp->isValid()){
                $manager = new ImageManager(new Driver());
                $image = $manager->read($image_tmp);
                $extension = $image_tmp->getClientOriginalExtension();
                $imageName =rand(111,99999).'.'.$extension;
                $image_path ='front/img/brands/'. $imageName;
                $image->save($image_path);
                $brand->image = $imageName;
            }
        }

        //Upload Logo Image
        if($request->hasFile('logo')){
            $sizechart_tmp = $request->file('logo');
            if($sizechart_tmp->isValid()){
                $manager = new ImageManager(new Driver());
                $image = $manager->read($sizechart_tmp);
                $sizechart_extension = $sizechart_tmp->getClientOriginalExtension();
                $sizechart_imageName =rand(111,99999).'.'.$sizechart_extension;
                $sizechartimage_path ='front/img/logos/'. $sizechart_imageName;
                $image->save($sizechartimage_path);
                $brand->logo = $sizechart_imageName;
            }
        }

         /*
        |--------------------------------------------------------------------------
        | Format Name & URL
        |--------------------------------------------------------------------------
        */
        $data['name'] = ucwords(strtolower(str_replace("-", " ", $data['name'])));
        $data['url'] = strtolower(str_replace(" ", "-", $data['url']));

        $brand->name = $data['name'];
        $brand->url = $data['url'];

        /*
        |--------------------------------------------------------------------------
        | Discount
        |--------------------------------------------------------------------------
        */
       $brand->discount = $data['brand_discount'] ?: 0;

        /*
        |--------------------------------------------------------------------------
        | Meta Fields
        |--------------------------------------------------------------------------
        */
        $brand->description       = $data['description'];
        $brand->meta_title        = $data['meta_title'];
        $brand->meta_description  = $data['meta_description'];
        $brand->meta_keywords     = $data['meta_keywords'];

        /*
        |--------------------------------------------------------------------------
        | Menu Status
        |--------------------------------------------------------------------------
        */
        $brand->menu_status = !empty($data['menu_status']) ? 1 : 0;

        /*
        |--------------------------------------------------------------------------
        | Default Status
        |--------------------------------------------------------------------------
        */
        $brand->status = 1;

        $brand->save();

        return $message;


    }


    public function updateBrandStatus($data){
    $status = ($data['status'] == 'Active') ? 0 : 1;

    Brand::where('id', $data['brand_id'])->update(['status' => $status]);

    return $status;
}

public function DeleteBrand($id){
    // Get brand first
    $brand = Brand::findOrFail($id);

    // Delete image from folder if exists
    $brandPath = public_path('front/img/brands/' . $brand->image);
    $logoPath = public_path('front/img/logos/' . $brand->logo);

    if (!empty($brand->image) && File::exists($brandPath)) {
        File::delete($brandPath);
    }
    // Delete logo if exists
    if (!empty($brand->logo) && File::exists($logoPath)) {
        File::delete($logoPath);
    }

    // Delete record from database
    $brand->delete();

    return [
        'message' => 'Brand deleted successfully!'
    ];
}

}
