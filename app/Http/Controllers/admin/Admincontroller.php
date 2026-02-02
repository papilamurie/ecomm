<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\DetailsRequest;
use App\Models\Admin;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\admin\LoginRequest;
use App\Services\admin\AdminService;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\admin\PasswordRequest;
use App\Http\Requests\admin\SubadminRequest;
use App\Models\ColumnPreference;

class Admincontroller extends Controller
{
    protected $AdminService;
    /**
     * Display a listing of the resource.
     */
    // Inject AdminService using  Constructor
    public function __construct(AdminService $AdminService){
        $this->AdminService = $AdminService;
    }
    public function index()
    {
        Session::put('page','dashboard');
        $categoriesCount = \App\Models\Category::get()->count();
        $productsCount = \App\Models\Product::get()->count();
        $brandsCount = \App\Models\Brand::get()->count();
        $usersCount = \App\Models\User::get()->count();
        $couponsCount = 0;
        $ordersCount = 0;
        $pagesCount = 0;
        $enquiriesCount = 0;
        return view('admin.dashboard')->with(compact(
            'categoriesCount',
            'productsCount',
            'brandsCount',
            'usersCount',
            'couponsCount',
            'ordersCount',
            'pagesCount',
            'enquiriesCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoginRequest $request)
    {
        $data = $request->all();
        $loginStatus =$this->AdminService->login($data);
        if($loginStatus == 'success'){
            return redirect()->route('dashboard.index');
        }elseif($loginStatus == 'inactive'){
            return redirect()->back()->with('error_message', 'Your Account is inactive');
        }else{
            return redirect()->back()->with('error_message', 'Invalid Email or Password');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        Session::put('page','update-password');
        return view('admin.update-password');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function verifyPassword(Request $request)
    {
        $data = $request->all();
        return $this->AdminService->verifyPassword($data);
    }

    public function updatePasswordRequest(PasswordRequest $request)
    {
        if($request->isMethod('post')){
            $data = $request->input();

            $pwdStatus = $this->AdminService->updatePassword($data);
            if($pwdStatus['status']=='success'){
                return redirect()->back()->with('success_message', $pwdStatus['message']);
            }else{
                return redirect()->back()->with('error_message', $pwdStatus['message']);
            }
        }
    }

    /**
     * Show the admin details.
     */
    public function editDetails(Admin $admin)
    {
        Session::put('page','update-details');
        return view('admin.update-details');
    }

    public function updateDetails(DetailsRequest $request)
    {
        Session::put('page', 'update-details');
        if($request ->isMethod('post')){
            $this->AdminService->updateDetails($request);
            return redirect()->back()->with('success_message', 'Admin Details have been Updated');
        }
    }

     public function deleteProfileImage(Request $request)
    {
        $status = $this->AdminService->deleteProfileImageService($request->admin_id);
        return response()->json($status);
    }
     public function subadmins()
    {
        Session::put('page', 'subadmins');
        $subadmins = $this->AdminService->subadmins();
        return view('admin.subadmins.subadmins')->with(compact('subadmins'));
    }

    public function updateSubadminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $status = $this->AdminService->updateSubadminStatus($data);
            return response()->json(['status'=> $status, 'subadmin_id' => $data['subadmin_id']]);
        }
    }

    public function deleteSubadmin($id){
        $result = $this->AdminService->deleteSubadmin($id);
        return redirect()->back()->with('success_message', $result['message']);
    }

    public function addEditSubadmin($id=null){
        if($id == ""){
            $title = "Add Sub-Admin";
            $subadmindata = array();
        }else{
            $title = "Edit Sub-Admin";
            $subadmindata = Admin::find($id);
        }
        return view('admin.subadmins.add_edit_subadmin')->with(compact('title','subadmindata'));
    }

    public function addEditSubadminRequest(SubadminRequest $request){
        if($request->isMethod('post')){
            $result = $this->AdminService->addEditSubadmin($request);
            return redirect('admin/subadmins')->with('success_message', $result['message']);
        }
    }

  public function updateRole($id) {
    $subadminroles = AdminsRole::where('subadmin_id', $id)->get()->toArray();
    $subadmindetails = Admin::where('id', $id)->first()->toArray();
    $modules = ['categories', 'products','orders','users','banners','brands','filters','filter_values','coupons','currencies'];
    $title = "Update " . $subadmindetails['name'] . " Subadmin Roles/Permissions";

    return view('admin.subadmins.update_roles', compact(
        'title',
        'id',
        'subadminroles','modules'));
}




    public function updateRoleRequest(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $service = new AdminService();
            $result = $service->updateRole($request);
             return redirect()->back()->with('success_message', $result['message']);
        }
    }

    public function saveColumnVisibility(Request $request){
        $userId = Auth::guard('admin')->id();
        $tablename = $request->table_key;
        if(!$tablename){
            return response()->json(['status' => 'error', 'message' => 'Table key is required.'], 400);
        }
        ColumnPreference::updateOrCreate(
            ['admin_id' => $userId, 'table_name' => $tablename],
            ['column_order' => json_encode($request->column_order),
             'hidden_columns' => json_encode($request->hidden_columns)]
        );
        return response()->json(['status' => 'success']);
    }
}
