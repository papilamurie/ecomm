<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Services\admin\BrandService;
use App\Models\ColumnPreference;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\admin\BrandRequest;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        Session::put('page', 'brands');

    $result = $this->brandService->brands();

    if ($result['status'] === 'error') {
        return redirect('admin/dashboard')
            ->with('error_message', $result['message']);
    }

    $brands = $result['brands'];
    $brandsModule = $result['brandsModule'];

    // Get saved column preferences
    $columnPrefs = ColumnPreference::where('admin_id', Auth::guard('admin')->id())
        ->where('table_name','brands')
        ->first();

    // ⚡ Default to empty arrays, not null
    $brandsSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
    $brandsHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];

    return view('admin.brands.index', compact(
        'brands',
        'brandsModule',
        'brandsSaveOrder',
        'brandsHiddenCols'
    ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Add Brand";
        return view('admin.brands.add_edit_brand', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $message = $this->brandService->addEditBrand($request);
        return redirect()->route('brands.index')->with('success_message', $message);
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
        $title = "Edit Brand";
        $brand = Brand::findOrFail($id);
        return view('admin.brands.add_edit_brand', compact('title','brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        $request->merge(['id'=>$id]);
        $message = $this->brandService->addEditBrand($request);
        return redirect()->route('brands.index')->with('success_message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->brandService->DeleteBrand($id);
        return redirect()->back()->with('success_message', $result['message']);
    }

    public function updateBrandStatus(Request $request){
    if($request->ajax()){
        $data = $request->all();
        $status = $this->brandService->updateBrandStatus($data);
        return response()->json(['status'=> $status]);
    }
}


}
