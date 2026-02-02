<?php
namespace App\Services\admin;

use App\Models\AdminsRole;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CurrencyService
{
    public function currencies()
    {
        $currencies = Currency::orderBy('is_base', 'desc')->orderBy('code')->get();
        $admin = Auth::guard('admin')->user();
        $status = "success";
        $message = "";
        $currenciesModule = [];

        if ($admin->role == "admin") {
            $currenciesModule = ['view_access' => 1, 'edit_access' => 1, 'full_access' => 1];
        } else {
            $cnt = AdminsRole::where([
                'subadmin_id' => $admin->id ?? 0,
                'module' => 'currencies',
            ])->count();

            if ($cnt == 0) {
                $status = 'error';
                $message = 'This Feature is restricted for you!';
            } else {
                $currenciesModule = AdminsRole::where([
                    'subadmin_id' => $admin->id,
                    'module' => 'currencies',
                ])->first()->toArray();
            }
        }

        return [
            'currencies' => $currencies,
            'currenciesModule' => $currenciesModule,
            'status' => $status,
            'message' => $message
        ];
    }

    public function addEditCurrency($request)
    {
        $data = $request->all();

        if (!empty($data['id'])) {
            $currency = Currency::findOrFail($data['id']); // Fixed: findorFail -> findOrFail
            $message = "Currency updated successfully!";
        } else {
            $currency = new Currency;
            $message = "Currency added successfully!"; // Fixed: Capitalization consistency
        }

        $currency->code = strtoupper(trim($data['code'] ?? $currency->code));
        $currency->symbol = $data['symbol'] ?? $currency->symbol;
        $currency->name = $data['name'] ?? $currency->name;

        $isBase = !empty($data['is_base']) ? 1 : 0;

        if ($isBase) {
            // Unset all other base currencies
            Currency::where('is_base', true)
                ->where('id', '!=', $currency->id ?? 0) // Fixed: Added null coalescing for new records
                ->update(['is_base' => false]);

            $currency->is_base = 1;
            $currency->rate = 1.00000000;
        } else {
            if (isset($data['rate'])) {
                $currency->rate = (float)$data['rate'];
            }
            $currency->is_base = 0;
        }

        $currency->status = isset($data['status']) ? (int)$data['status'] : ($currency->status ?? 1);

        // Flag upload -> public/front/img/flags/
        if ($request->hasFile('flag') && $request->file('flag')->isValid()) {
            $destination = public_path('front/img/flags/');

            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            // Remove old image
            if (!empty($currency->flag) && File::exists($destination . $currency->flag)) {
                @unlink($destination . $currency->flag);
            }

            $file = $request->file('flag');
            $ext = $file->getClientOriginalExtension();
            $filename = Str::lower($currency->code ?: 'flag') . '-' . time() . '.' . $ext;
            $file->move($destination, $filename);
            $currency->flag = $filename;
        } elseif (!empty($data['flag'])) {
            $currency->flag = $data['flag'];
        }

        $currency->save();

        return $message;
    }

    public function updateCurrencyStatus($data)
{
    $currency = Currency::findOrFail($data['currency_id'] ?? $data['id']);

    // Get the new status (either from 'new_status' set in controller or toggle)
    if (isset($data['new_status'])) {
        $status = (int)$data['new_status'];
    } elseif (isset($data['status'])) {
        $status = (int)$data['status'];
    } else {
        $status = $currency->status ? 0 : 1; // Toggle
    }

    // Prevent disabling base currency
    if ($currency->is_base && $status === 0) {
        throw new \Exception('Cannot disable base currency!');
    }

    $currency->status = $status;
    $currency->save();

    return $currency->status;
}

    public function deleteCurrency($id)
    {
        $currency = Currency::findOrFail($id); // Fixed: findorFail -> findOrFail

        if ($currency->is_base) {
            return ['status' => false, 'message' => 'Cannot delete base currency'];
        }

        // Remove flag from public folder
        $path = public_path('front/img/flags/' . $currency->flag);

        if (!empty($currency->flag) && File::exists($path)) {
            @unlink($path);
        }

        $currency->delete();

        return ['status' => true, 'message' => 'Currency deleted successfully!'];
    }
}
