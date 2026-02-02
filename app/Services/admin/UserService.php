<?php
namespace App\Services\admin;

use App\Models\AdminsRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function users(array $filters=[]): array
    {
        $query = User::query();
        if(!empty($filters['search'])){
            $s = trim($filters['search']);
            $query->where(function($q) use ($s){
                $q->where('email', 'like', "%{$s}%")
                   ->orWhere('email', 'like', "%{$s}%");
            });
        }

        $users =$query->orderBy('created_at','desc')->paginate(20);
        $admin = Auth::guard('admin')->user();
        $status = "success";
        $message = "";
        $usersModule = [];
        if($admin && ($admin->role == "admin")){
            $usersModule = ['view_access'=>1,'edit_access'=>1,'full_access'=>1];
        }else{
            $usersModuleCount = AdminsRole::where([
                'subadmin_id' => $admin->id ?? 0,
                'module' => 'users',
            ])->count();
         if($usersModuleCount == 0){
            $status = 'error';
            $message= 'This Feature is restricted for you!';
         }else{
            $usersModuleCount = AdminsRole::where([
                'subadmin_id' => $admin->id,
                'module' => 'users',
            ])->first()->toArray();
         }
        }
        return ['users'=>$users, 'usersModule'=>$usersModule, 'status'=>$status, 'message'=>$message];
    }

    public function updateUserStatus($data)
    {
        //toggle status
        $user = User::findorFail($data['user_id']);
        $user->status = $user->status ? 0 : 1;
        $user->save();
        return $user->status;


    }
}
