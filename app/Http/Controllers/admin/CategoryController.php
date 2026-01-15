<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\admin\CategoryService;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\admin\CategoryRequest;
use App\Models\ColumnPreference;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display list of categories
     */
    public function index()
{
    Session::put('page', 'categories');

    $result = $this->categoryService->categories();

    if ($result['status'] === 'error') {
        return redirect('admin/dashboard')
            ->with('error_message', $result['message']);
    }

    $categories = $result['categories'];
    $categoriesModule = $result['categoriesModule'];

    // Get saved column preferences
    $columnPrefs = ColumnPreference::where('admin_id', Auth::guard('admin')->id())
        ->where('table_name','categories')
        ->first();

    // ⚡ Default to empty arrays, not null
    $categoriesSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
    $categoriesHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];

    return view('admin.categories.index', compact(
        'categories',
        'categoriesModule',
        'categoriesSaveOrder',
        'categoriesHiddenCols'
    ));
}

    /**
     * Show form for creating a new category
     */
    public function create()
    {
        $title = 'Add Category';
        $category = new Category();

        // Fetch nested categories for dropdown
        $getCategories = Category::getCategories('Admin');

        return view('admin.categories.add_edit_category', compact(
            'title',
            'category',
            'getCategories'
        ));
    }

    /**
     * Store new category
     */
    public function store(CategoryRequest $request)
    {
        $message = $this->categoryService->addEditCategory($request);

        return redirect()
            ->route('categories.index')
            ->with('success_message', $message);
    }

    /**
     * Edit category
     */
    public function edit($id)
    {
        $title = "Edit Category";
        $category = Category::findOrFail($id);

        $getCategories = Category::getCategories('Admin');

        return view('admin.categories.add_edit_category', compact(
            'title',
            'category',
            'getCategories'
        ));
    }

    /**
     * Update category
     */
    public function update(CategoryRequest $request, $id)
    {
        $request->merge(['id' => $id]);

        $message = $this->categoryService->addEditCategory($request);

        return redirect()
            ->route('categories.index')
            ->with('success_message', $message);
    }

    /**
     * Delete category (optional)
     */
    public function destroy($id)
    {
        $result = $this->categoryService->DeleteCategory($id);
        return redirect()->back()->with('success_message', $result['message']);
    }

    public function updateCategoryStatus(Request $request){
    if($request->ajax()){
        $data = $request->all();
        $status = $this->categoryService->updateCategoryStatus($data);
        return response()->json(['status'=> $status]);
    }
}
 public function deleteCategoryImage(Request $request)
    {
        $status = $this->categoryService->deleteCategoryImageService($request->category_id);
        return response()->json($status);
    }

    public function deleteSizechartImage(Request $request)
    {
        $status = $this->categoryService->deleteSizechartImageService($request->category_id);
        return response()->json($status);
    }



}
