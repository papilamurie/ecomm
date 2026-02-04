<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ReviewRequest;
use App\Models\ColumnPreference;
use App\Models\Review;
use App\Services\admin\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         Session::put('page', 'reviews');

        $result = $this->reviewService->reviews(); // Fixed: changed from coupons() to currencies()

        if ($result['status'] === 'error') {
            return redirect('admin/dashboard')
                ->with('error_message', $result['message']);
        }

        $reviews = $result['reviews'];
        $reviewsModule = $result['reviewsModule'];

        // Get saved column preferences
        $columnPrefs = ColumnPreference::where('admin_id', Auth::guard('admin')->id())
            ->where('table_name', 'reviews')
            ->first();

        // Default to empty arrays, not null
        $reviewsSaveOrder = $columnPrefs ? json_decode($columnPrefs->column_order, true) : [];
        $reviewsHiddenCols = $columnPrefs ? json_decode($columnPrefs->hidden_columns, true) : [];

        return view('admin.reviews.index', compact(
            'reviews',
            'reviewsModule',
            'reviewsSaveOrder',
            'reviewsHiddenCols'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Review';
        $review = new Review();
        return view('admin.reviews.add_edit_review', compact('title','review'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request)
    {
        $message = $this->reviewService->addEditReview($request);
        return redirect()->route('reviews.index')->with('success_message',$message);
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
        $title = 'Edit Review';
        $review = Review::findorFail($id);
        return view('admin.reviews.add_edit_review',compact('title','review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRequest $request, string $id)
    {
        $request->merge(['id'=>$id]);
        $message = $this->reviewService->addEditReview($request);
        return redirect()->route('reviews.index')->with('success_message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->reviewService->deleteReview($id);
        return redirect()->back()->with('success_message',$result['message']);
    }

    public function updateReviewStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            $status = $this->reviewService->updateReviewStatus($data);
            return response()->json(['status'=>$status, 'review_id'=>$data['review_id']]);
        }
    }
}
