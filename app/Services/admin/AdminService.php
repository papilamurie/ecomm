<?php

namespace App\Services\admin;

use App\Models\Admin;
use App\Models\AdminsRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminService {
    public function login($data){
        $admin = Admin::where('email', $data['email'])->first();
        if($admin){
            if($admin->status == 0){
                return "inactive";
            }

        if(Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])){

                //Remember me code
            if(!empty($data['remember'])){
                setcookie('email',$data['email'],time()+3600);
                setcookie('passowrd',$data['password'],time()+3600);
            }else{
                setcookie("email", "");
                setcookie("password","");
            }


            return "success";
        }else{
            return "invalid";
        }

    }else{
                return "invalid";
    }
    }
    public function verifyPassword($data){
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updatePassword($data)
    {
        //check if the password is correct
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            //check new and confirm password match
            if($data['new_pwd']==$data['confirm_pwd']){
                Admin::where('email', Auth::guard('admin')->user()->email)
                ->update(['password' => bcrypt($data['new_pwd'])]);
                $status = 'success';
                $message = 'Password has been updated successufully!';
            }else{
                $status = 'error';
                $message = 'New password and Confirm password must match!';
            }
        }else{
            $status = 'error';
                $message = 'Current Password is Wrong!';
        }
        return ['status' => $status, "message" =>$message];
    }

        public function updateDetails($request)
        {
            $data = $request->all();
            //update Admin Image
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($image_tmp);
                        $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extension;
                    $image_path= 'admin/img/photos/'.$imageName;
                    $image->save($image_path);
                }
            }else if(!empty($data['current_image'])){
                $imageName = $data['current_image'];
            }else{
                $imageName = "";
            }

            //Update AdminDetails
            Admin::where('email', Auth::guard('admin')->user()->email)->update([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'image' => $imageName
            ]);
        }

      public function deleteProfileImageService($admin_id)
{
    $profileImage = Admin::where('id', $admin_id)->value('image');

    if($profileImage){
        $path = public_path('admin/img/photos/' . $profileImage);

        if(file_exists($path)){
            unlink($path);
        }

        Admin::where('id', $admin_id)->update(['image' => null]);

        return ['status' => true, 'message' => 'Profile image deleted successfully!'];
    }

    return ['status' => false, 'message' => 'Profile image not found!'];
}

public function subadmins(){
    $subadmins = Admin::where('role', 'subadmin')->get();
    return $subadmins;
}

public function updateSubadminStatus($data){
        $status = ($data['status']=='Active') ? 0 : 1;
        Admin::where('id', $data['subadmin_id'])->update(['status' => $status]);
        return $status;
}

public function deleteSubadmin($id){
    //delete subadmin
    Admin::where('id', $id)->delete();
    $message = 'Subadmin deleted successfully!';
    return array("message" =>$message);
}

public function addEditSubadmin($request)
{
    $data = $request->all();

    // Find existing or create new
    if (!empty($data['id'])) {
        $subadmindata = Admin::find($data['id']);
        $message = 'Subadmin Updated Successfully';

        if (!$subadmindata) {
            return ['message' => 'Subadmin not found'];
        }

    } else {
        $subadmindata = new Admin();
        $message = 'Subadmin Added Successfully';
    }

    // ------------------------------------
    // Handle Image Upload
    // ------------------------------------
    if ($request->hasFile('image')) {

        $image_tmp = $request->file('image');

        if ($image_tmp->isValid()) {

            $manager = new ImageManager(new Driver());
            $image = $manager->read($image_tmp);

            $extension = $image_tmp->getClientOriginalExtension();
            $imageName = rand(111, 99999).'.'.$extension;
            $image_path = 'admin/img/photos/'.$imageName;

            // Save image
            $image->save($image_path);
        }

    } else {

        // Use existing image if available
        $imageName = $data['current_image'] ?? "";

    }

    // Assign image
    $subadmindata->image = $imageName;

    // ------------------------------------
    // Update fields
    // ------------------------------------
    $subadmindata->name   = $data['name'];
    $subadmindata->mobile = $data['mobile'];

    if (empty($data['id'])) {
        // New subadmin
        $subadmindata->email  = $data['email'];
        $subadmindata->role   = 'subadmin';
        $subadmindata->status = 1;
    }

    // Update password if provided
    if (!empty($data['password'])) {
        $subadmindata->password = bcrypt($data['password']);
    }

    // Save model
    $subadmindata->save();

    return ["message" => $message];
}

public function updateRole($request){
    $data = $request->all();

    //Remove Existing roles before updating
    AdminsRole::where('subadmin_id', $data['subadmin_id'])->delete();

    //Assign new role
    foreach($data as $key=>$value){
        if(!is_array($value)) continue; // Skip non-module fields

        $view = isset($value['view']) ? $value['view']:0;
        $edit = isset($value['edit']) ? $value['edit']:0;
        $full = isset($value['full']) ? $value['full']:0;
        AdminsRole::insert([
            'subadmin_id' => $data['subadmin_id'],
            'module' => $key,
            'view_access' => $view,
            'edit_access' => $edit,
            'full_access' => $full
        ]);
    }
    return ['message' => 'Subadmin Roles Updated Successfully!'];
}


}
