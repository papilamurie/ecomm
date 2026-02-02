<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CouponRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ColumnPreference;
use App\Models\Coupon;
use App\Models\User;
use App\Services\admin\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
       $this->couponService = $couponService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'coupons');

    $result = $this->couponService->coupons();

    if ($result['status'] === 'error') {
        return redirect('admin/dashboard')
            ->with('error_message', $result['message']);
    }

    $coupons = $result['coupons'];
    $couponsModule = $result['couponsModule'];

    // Get saved column preferences
    $columnPrefs = ColumnPreference::where('admin_id', Auth::guard('admin')->id())
        ->where('table_name','coupons')
        ->first();

    // ⚡ Default to empty arrays, not null
    $couponsSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
    $couponsHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];

    return view('admin.coupons.index', compact(
        'coupons',
        'couponsModule',
        'couponsSaveOrder',
        'couponsHiddenCols'
    ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $title = 'Add Coupon';
    $coupon = new Coupon();

    //Normalize arrays expected in view
    $coupon->categories = [];
    $coupon->brands = [];
    $coupon->users = [];

    //Categories
    $categories = Category::getCategories('Admin');

    //brands (id=>name)
    $brands = Brand::orderBy('name')->pluck('name','id')->toArray();

    //users list(Email)
    $users = User::select('email')->get()->toArray();

    $selCats = [];
    $selBrands = [];
    $selUsers = [];

    return view('admin.coupons.add_edit_coupon',
        compact('title','coupon','categories','brands','users','selCats','selBrands','selUsers'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        $data = $request->validated();
        $message = $this->couponService->addEditCoupon($data);
        return redirect()->route('coupons.index')->with('success_message', $message);
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
    public function edit($id)
    {
        $title = 'Edit Coupon';
        $coupon = Coupon::findOrFail($id);

        $coupon->categories = $coupon->categories ?
        (is_array($coupon->categories) ? $coupon->categories : json_decode($coupon->categories,true)) : [];
        $coupon->brands = $coupon->brands ?
        (is_array($coupon->brands) ? $coupon->brands : json_decode($coupon->brands,true)) : [];
        $coupon->users = $coupon->users ?
        (is_array($coupon->users) ? $coupon->users : json_decode($coupon->users,true)) : [];
        $categories = Category::getCategories('Admin');
        $brands = Brand::orderBy('name')->pluck('name','id')->toArray();
        $users = User::select('email')->get()->toArray();
        $selCats = $coupon->categories;
        $selBrands = $coupon->brands;
        $selUsers = $coupon->users;
         return view('admin.coupons.add_edit_coupon',
        compact('title','coupon','categories','brands','users','selCats','selBrands','selUsers'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $message = $this->couponService->addEditCoupon($data);
        return redirect()->route('coupons.index')->with('success_message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Coupon::where('id',$id)->delete();
        return redirect()->back()->with('success_message','Coupon Deleted Successfully');
    }

    public function updateCouponStatus(Request $request)
    {
        if($request->ajax()){
            $data =$request->all();
            $status = ($data['status'] == 'Active') ? 0 : 1;
            $coupon = \App\Models\Coupon::find($data['coupon_id']);
            if($coupon){
                $coupon->status = $status;
                $coupon->save();
            }
            return response()->json(['status' => $status, 'coupon_id' => $data['coupon_id']]);
        }
    }
}
