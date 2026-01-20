<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\FilterValueRequest;
use App\Models\ColumnPreference;
use App\Models\Filter;
use App\Models\FilterValue;
use App\Services\admin\FilterValueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class FilterValueController extends Controller
{
    protected $filterValueService;
    public function __construct(FilterValueService $filterValueService)
    {
        $this->filterValueService = $filterValueService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($filterId)
    {
        Session::put('page','filters');

        $filter = Filter::findorFail($filterId);
        $result = $this->filterValueService->getAll($filterId);
        if($result['status'] === 'error'){
            return redirect('admin/dashboard')
                ->with('error_message', $result['message']);
        }
        $filterValues = $result['filterValues'];
        $filterValuesModule = $result['filterValuesModule'];
        $columnPrefs = ColumnPreference::where('admin_id', auth()->guard('admin')->id())
            ->where('table_name','filter_values')
            ->first();
            $filterValuesSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
            $filterValuesHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];
        return view('admin.filter_values.index', compact(
            'filter',
            'filterValues',
            'filterValuesModule',
            'filterValuesSaveOrder',
            'filterValuesHiddenCols'
        ))->with('title', 'Filter Values');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($filterId)
    {
        $filter = Filter::findorFail($filterId);
        $title = 'Add Filter Value';
        return view('admin.filter_values.add_edit_filter_value', compact('filter', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilterValueRequest $request, $filterId)
    {
        $filter = Filter::findOrFail($filterId);

        $this->filterValueService->store($request->validated(), $filterId);

        return redirect()->route('filter_values.index', $filterId)->with('success_message', 'Filter Value created successfully.');
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
    public function edit($filterId, $id)
    {
        $filter = Filter::findOrFail($filterId);
        $filterValue = $this->filterValueService->find($filterId, $id);
        $title = 'Edit Filter Value';
        return view('admin.filter_values.add_edit_filter_value', compact('filter', 'filterValue', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(FilterValueRequest $request, $filterId, $id)
{
    $this->filterValueService->update(
        $filterId,
        $id,
        $request->validated()
    );

    return redirect()
        ->route('filter_values.index', $filterId)
        ->with('success_message', 'Filter Value updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($filterId, $id)
    {

        $this->filterValueService->delete($filterId, $id);
        return redirect()->route('filter_values.index', $filterId)->with('success_message', 'Filter Value deleted successfully.');
    }
}
