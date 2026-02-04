<?php
namespace App\Services\front;

use App\Models\Review;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewService
{
    public function addReview(array $data): array
    {
        $userId = $data['user_id'] ?? Auth::id();
        $productId = $data['product_id'] ?? null;
        $rating = $data['rating'] ?? null;
        $reviewText = $data['review'] ?? null;
        if(!$userId || !$productId || !$rating){
            return ['status'=>'error','message'=>'Invalid data provided!'];
        }
        if(Review::where('product_id',$productId)->where('user_id',$userId)->exists())
            {
                return ['status'=>'error','message'=>'You have already reviewed this product.'];
            }
        try{
            Review::create([
                'product_id'=>$productId,
                'user_id' => $userId,
                'rating'=>(int)$rating,
                'review'=>$reviewText,
                'status'=>0,
            ]);
        }catch(QueryException $e){
            Log::error('Review create failed: '.$e->getMessage());
            return ['status'=>'error','message'=>'Unable to submit review!'];
        }
        return ['status'=>'success','message'=>'Thank you! Your review will appear after admin approval.'];
    }
}
