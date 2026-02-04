<?php
namespace App\Services\admin;

use App\Models\AdminsRole;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
     public function reviews(): array
    {
        $admin = Auth::guard('admin')->user();
        $reviews = Review::orderBy('id', 'desc')->get();
        $status = "success";
        $message = "";
        $reviewsModule = [];

        if ($admin->role == "admin") {
            $reviewsModule = ['view_access' => 1, 'edit_access' => 1, 'full_access' => 1];
        } else {
            $cnt = AdminsRole::where([
                'subadmin_id' => $admin->id ?? 0,
                'module' => 'reviews',
            ])->count();

            if ($cnt == 0) {
                $status = 'error';
                $message = 'This Feature is restricted for you!';
            } else {
                $reviewsModule = AdminsRole::where([
                    'subadmin_id' => $admin->id,
                    'module' => 'reviews',
                ])->first()->toArray();
            }
        }

        return [
            'reviews' => $reviews,
            'reviewsModule' => $reviewsModule,
            'status' => $status,
            'message' => $message
        ];
    }

    public function addEditReview($request): string
    {
        $data = is_array($request) ? $request : $request->only(['id','product_id','rating','status']);
        if(!empty($data['id'])){
            $review = Review::findorFail($data['id']);
            if(!$review) return 'Review no found!';
        }else{
            $review = new Review();
        }
        $review->product_id = $data['product_id'] ?? $review->product_id;
        $review->rating = $data['rating'] ?? $review->rating;
         $review->review = $data['review'] ?? $review->review;
         if(isset($data['status'])) $review->status = $data['status'];
         $review->save();
         return isset($data['id']) ? 'Review updated successfully!' : 'Review added successfully!';
    }

    public function updateReviewStatus(array $data)
    {
        $status = ($data['status']=="Active") ? 0 : 1;
        Review::where('id',$data['review_id'])->update(['status'=>$status]);
        return $status;
    }

    public function deleteReview($id): array
    {
        $review = Review::findorFail($id);
        if(!$review) return ['status'=>'error','message'=>'Review not found!'];
        $review->delete();
        return ['status'=>'success','message'=>'Review deleted successfully!'];
    }

}
