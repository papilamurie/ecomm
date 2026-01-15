<?php

namespace App\Services\admin;

use App\Models\Banners;
use App\Models\AdminsRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BannerService
{
    public function banners()
    {
        $banners = Banners::get();
        $admin = Auth::guard('admin')->user();
        $status = "success";
        $message = "";
        $bannersModule = [];

        // If admin → full access
        if ($admin->role == "admin") {
            $bannersModule = [
                'view_access' => 1,
                'edit_access' => 1,
                'full_access' => 1
            ];
        } else {
            // Subadmin permissions
            $bannersModuleCount = AdminsRole::where([
                'subadmin_id' => $admin->id,
                'module' => 'banners'
            ])->count();

            if($bannersModuleCount == 0){
                $status = 'error';
                $message = 'This feature is not available for your role!';
            }else{
                $bannersModule = AdminsRole::where([
                    'subadmin_id' => $admin->id,
                    'module'=>'banners'
                ])->first()->toArray();
            }
         }

        return [
            "banners" => $banners,
            "bannersModule" => $bannersModule,
            "status" => $status,
            "message" => $message
        ];
    }

    public function addEditBanner($request){
        $data = $request->all();

        $banner = isset($data['id']) ? Banners::find($data['id']) : new Banners();

        $banner->type = $data['type'];
        $banner->link = $data['link'];
        $banner->title = $data['title'];
        $banner->alt = $data['alt'];
        $banner->sort = $data['sort'] ?? 0;
        $banner->status = $data['status'] ?? 1;

        //Handle image Upload
        if($request->hasFile('image')){
            $path = 'front/img/banners/';
           if (!empty($banner->image) && File::exists(public_path($path . $banner->image))) {
            File::delete(public_path($path . $banner->image));
        }
                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $image->move(public_path($path), $imageName);
                $banner->image = $imageName;
        }
        $banner->save();
        return isset($data['id']) ? 'Banner Updated Successfully!' : 'Bannner added successfully!';
    }






    public function updateBannerStatus($data){
    $status = ($data['status'] == 'Active') ? 0 : 1;

    Banners::where('id', $data['banner_id'])->update(['status' => $status]);

    return $status;
}

public function DeleteBanner($id){
   // Get banner first
    $banner = Banners::findOrFail($id);

    // Delete image from folder if exists
    $bannerPath = public_path('front/img/banners/' . $banner->image);
    if (!empty($banner->image) && File::exists($bannerPath)) {
        File::delete($bannerPath);
    }

    // Delete record from database
    $banner->delete();

    return [
        'message' => 'Banner deleted successfully!'
    ];
}



}
