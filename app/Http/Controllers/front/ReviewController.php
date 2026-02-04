<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\front\ReviewSubmitRequest;
use App\Services\front\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function store(ReviewSubmitRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $result = $this->reviewService->addReview($data);
        //Return JSON (for AJAX) or redirect back for normal submit
        if($request->expectsJson() ||$request->ajax()){
            return response()->json($result,$result['status']==='success' ? 200 : 422);
        }
        return back()->with($result['status'] . '_message', $result['message']);
    }
}
