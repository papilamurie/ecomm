<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UserFilterRequest;
use App\Models\ColumnPreference;
use App\Services\admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UserFilterRequest $request)
    {
         Session::put('page', 'users');

    $result = $this->userService->users($request->validated());

    if ($result['status'] === 'error') {
        return redirect('admin/dashboard')
            ->with('error_message', $result['message']);
    }

    $users = $result['users'];
    $usersModule = $result['usersModule'];

    // Get saved column preferences
    $columnPrefs = ColumnPreference::where('admin_id', Auth::guard('admin')->id())
        ->where('table_name','users')
        ->first();

    // ⚡ Default to empty arrays, not null
    $usersSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
    $usersHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];

    return view('admin.users.index', compact(
        'users',
        'usersModule',
        'usersSaveOrder',
        'usersHiddenCols'
    ));
    }

    public function updateUserStatus(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        if($request->ajax()){
            $data = $request->all();
            $status = $this->userService->updateUserStatus($data);
            return response()->json(['status'=>$status, 'user_id'=>$data['user_id']]);
        }
        abort(400);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
