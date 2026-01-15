<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use Illuminate\Http\Request;
use App\Http\Requests\admin\BannerRequest;
use App\Services\admin\BannerService;
use App\Models\ColumnPreference;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class BannersController extends Controller
{
    protected $bannerService;

    public function __construct(bannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        Session::put('page', 'banners');

    $result = $this->bannerService->banners();

    if ($result['status'] === 'error') {
        return redirect('admin/dashboard')
            ->with('error_message', $result['message']);
    }

    $banners = $result['banners'];
    $bannersModule = $result['bannersModule'];

    // Get saved column preferences
    $columnPrefs = ColumnPreference::where('admin_id', Auth::guard('admin')->id())
        ->where('table_name','banners')
        ->first();

    // ⚡ Default to empty arrays, not null
    $bannersSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
    $bannersHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];

    return view('admin.banners.index', compact(
        'banners',
        'bannersModule',
        'bannersSaveOrder',
        'bannersHiddenCols'
    ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
          $title = 'Add Banner';
        $banner = new Banners();
        return view('admin.banners.add_edit_banner', compact('title','banner'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        $message = $this->bannerService->addEditBanner($request);
        return redirect()->route('banners.index')->with('success_message',$message);
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
        $title = 'Edit Banner';
        $banner = Banners::findOrFail($id);
        return view('admin.banners.add_edit_banner', compact('title','banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, string $id)
    {
        $request->merge(['id' => $id]);
        $message = $this->bannerService->addEditBanner($request);
        return redirect()->route('banners.index')->with('success_message', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->bannerService->DeleteBanner($id);
        return redirect()->back()->with('success_message', $result['message']);
    }

     public function updateBannerStatus(Request $request){
    if($request->ajax()){
        $data = $request->all();
        $status = $this->bannerService->updateBannerStatus($data);
        return response()->json(['status'=> $status]);
    }
}
}
