<?php

namespace App\Services\admin;

use App\Models\AdminsRole;
use App\Models\Filter;
use Illuminate\Support\Facades\Auth;

class FilterService
{
    public function getAll()
    {
        // 1. Fetch all filters(with relations)
        $filters = Filter::with('categories')->get();

        // 2. Set Admin Submadmin permissions (if needed) - skipped for brevity
        $filterModuleCount = AdminsRole::where([
            'subadmin_id' => auth()->guard('admin')->id(),
            'module' => 'filters'
        ])->count();
        $status = "success";
        $message = "";
        $filtersModule = [];
        if(Auth::guard('admin')->user()->role == "admin"){
            $filtersModule = [
                'view_access' => 1,
                'edit_access' => 1,
                'full_access' => 1
            ];
        } elseif($filterModuleCount == 0){
            // No access
            $status = "error";
            $message = "This feature is not available for your role!";
        }else{
            // Get Permissions
            $filterModule = AdminsRole::where([
                'subadmin_id' => auth()->guard('admin')->id(),
                'module' => 'filters'
            ])->first()->toArray();
        }
        //3. return response

        return [
            "filters" => $filters,
            "filtersModule" => $filtersModule,
            "status" => $status,
            "message" => $message
        ];
    }

    public function store(array $data)
    {
        $filter = Filter::create([
            'filter_name' => $data['filter_name'],
            'filter_column' => $data['filter_column'],
            'sort' => $data['sort'] ?? 0,
            'status' => $data['status'] ?? 1,
        ]);

        $filter->categories()->sync($data['category_ids']);
        return $filter;
    }

    public function find($id)
    {
        return Filter::with('categories')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $filter = $this->find($id);
        $filter->update([
            'filter_name' => $data['filter_name'],
            'filter_column' => $data['filter_column'],
            'sort' => $data['sort'] ?? 0,
            'status' => $data['status'] ?? 1,
        ]);

        $filter->categories()->sync($data['category_ids']);
        return $filter;
    }

    public function delete($id)
    {
        $filter = $this->find($id);
        $filter->categories()->detach();
        return $filter->delete();
    }

    public function updateFilterStatus(array $data)
    {
       $status = ($data['status'] == 'Active') ? 0 : 1;
       Filter::where('id', $data['filter_id'])->update(['status' => $status]);
         return $status;
    }



}

