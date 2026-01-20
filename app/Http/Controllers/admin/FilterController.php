<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\FilterRequest;
use App\Models\Category;
use App\Models\ColumnPreference;
use App\Models\Filter;
use App\Services\admin\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FilterController extends Controller
{
    protected $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         Session::put('page','filters');
        $result = $this->filterService->getAll();
        $title = 'Filter Management';
        if($result['status'] === 'error'){
            return redirect('admin/dashboard')
                ->with('error_message', $result['message']);
        }
        $filters = $result['filters'];
        $filtersModule = $result['filtersModule'];
        $columnPrefs = ColumnPreference::where('admin_id', auth()->guard('admin')->id())
            ->where('table_name','filters')
            ->first();
            $filtersSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
            $filtersHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];
        return view('admin.filters.index', compact(
            'filters',
            'filtersModule',
            'filtersSaveOrder',
            'filtersHiddenCols',
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('subcategories')
            ->where('parent_id', 0)
            ->orWhereNull('parent_id')
            ->get();
        $title = 'Add Filter';
        return view('admin.filters.add_edit_filter', compact('categories', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilterRequest $request)
    {
        $this->filterService->store($request->validated());
        return redirect()->route('filters.index')->with('success_message', 'Filter created successfully.');
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
        $filter = Filter::with('categories')->findOrFail($id);

        $categories = Category::with('subcategories')
            ->where('parent_id', 0)
            ->orWhereNull('parent_id')
            ->where('status', 1)
            ->get();

        $selectedCategories = $filter->categories->pluck('id')->toArray();

        return view('admin.filters.add_edit_filter', [
            'title' => 'Edit Filter',
            'filter' => $filter,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilterRequest $request, string $id)
    {
        $this->filterService->update($id, $request->validated());
        return redirect()->route('filters.index')->with('success_message', 'Filter updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->filterService->delete($id);
        return redirect()->route('filters.index')->with('success_message', 'Filter deleted successfully.');
    }


    public function updateFilterStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $status = $this->filterService->updateFilterStatus($data);
            return response()->json(['status' => $status, 'filter_id' => $data['filter_id']]);
        }
    }
}
