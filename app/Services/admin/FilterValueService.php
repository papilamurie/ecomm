<?php

namespace App\Services\admin;

use App\Models\AdminsRole;
use App\Models\FilterValue;

class FilterValueService
{
    public function getAll($filterId)
    {
        $filterValues = FilterValue::where('filter_id', $filterId)->get();
        $filterValuesModuleCount = AdminsRole::where([
            'subadmin_id' => auth()->guard('admin')->id(),
            'module' => 'filter_values'
        ])->count();
        $status = "success";
        $message = "";
        $filterValuesModule = [];
        if(auth()->guard('admin')->user()->role == "admin"){
            $filterValuesModule = [
                'view_access' => 1,
                'edit_access' => 1,
                'full_access' => 1
            ];
        } elseif($filterValuesModuleCount == 0){
            // No access
            $status = "error";
            $message = "This feature is not available for your role!";
        }else{
            // Get Permissions
            $filterValuesModule = AdminsRole::where([
                'subadmin_id' => auth()->guard('admin')->id(),
                'module' => 'filter_values'
            ])->first()->toArray();
    }
        return [
            "filterValues" => $filterValues,
            "filterValuesModule" => $filterValuesModule,
            "status" => $status,
            "message" => $message
        ];

    }

    public function store(array $data, $filterId)
    {
        return FilterValue::create([
            'filter_id' => $filterId,
            'value' => $data['value'],
            'sort' => $data['sort'] ?? 0,
            'status' => $data['status'] ?? 1,
        ]);
    }

    public function find($filterId, $id)
    {
        return FilterValue::where('filter_id', $filterId)->findOrFail($id);
    }

    public function update($filterId, $id, array $data)
    {
        $filterValue = $this->find($filterId, $id);
        $filterValue->update([
            'value' => $data['value'],
            'sort' => $data['sort'] ?? 0,
            'status' => $data['status'] ?? 1,
        ]);

        return $filterValue;
    }

    public function delete($filterId, $id)
    {
        $filterValue = $this->find($filterId, $id);
        return $filterValue->delete();
    }

}
