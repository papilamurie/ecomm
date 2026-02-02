<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CurrencyRequest;
use App\Models\ColumnPreference;
use App\Models\Currency;
use App\Services\admin\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService; // Fixed: removed extra $
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'currencies');

        $result = $this->currencyService->currencies(); // Fixed: changed from coupons() to currencies()

        if ($result['status'] === 'error') {
            return redirect('admin/dashboard')
                ->with('error_message', $result['message']);
        }

        $currencies = $result['currencies'];
        $currenciesModule = $result['currenciesModule'];

        // Get saved column preferences
        $columnPrefs = ColumnPreference::where('admin_id', Auth::guard('admin')->id())
            ->where('table_name', 'currencies')
            ->first();

        // Default to empty arrays, not null
        $currenciesSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
        $currenciesHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];

        return view('admin.currencies.index', compact(
            'currencies',
            'currenciesModule',
            'currenciesSaveOrder',
            'currenciesHiddenCols'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.currencies.add_edit_currency');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request) // Fixed: added CurrencyRequest type hint
    {
        $message = $this->currencyService->addEditCurrency($request);
        return redirect()->route('currencies.index')->with('success_message', $message);
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
        $currency = Currency::findOrFail($id);
        return view('admin.currencies.add_edit_currency', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, $id)
    {
        $request->merge(['id' => $id]);
        $message = $this->currencyService->addEditCurrency($request);
        return redirect()->route('currencies.index')->with('success_message', $message); // Fixed: typo
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->currencyService->deleteCurrency($id);

        if (!empty($result['status']) && $result['status'] === true) {
            return redirect()->route('currencies.index')->with('success_message', $result['message']);
        }

        return redirect()->route('currencies.index')->with('error_message', $result['message'] ?? 'Could not delete currency!');
    }

    public function updateCurrencyStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if (empty($data['currency_id']) && !empty($data['id'])) {
                $data['currency_id'] = $data['id'];
            }

            try {
                $newStatus = $this->currencyService->updateCurrencyStatus($data);
                return response()->json([
                    'status' => 'success',
                    'currency_id' => $data['currency_id'],
                    'status_value' => (int)$newStatus
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid request'
        ], 400);
    }
}
