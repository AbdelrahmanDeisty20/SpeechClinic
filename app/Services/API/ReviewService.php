<?php

namespace App\Services\API;

use App\Http\Resources\API\ReviewResource;
use App\Models\Review;
use App\Traits\API\ApiResponse;

class ReviewService
{
    use \App\Traits\ApiResponse;

    /**
     * Create a new class instance.
     */
    public function createReview(array $data)
    {
        $review = Review::create([
            'name' => $data['name'],
            'comment' => $data['comment'],
            'rate' => $data['rate'],
            'is_active' => true,
            'user_id' => auth()->id(),
        ]);

        return [
            'status' => true,
            'message' => __('messages.review_created_successfully'),
            'data' => new ReviewResource($review)
        ];
    }

    public function getAllReviews()
    {
        $reviews = Review::where('is_active', true)->paginate(10);

        if ($reviews->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.reviews_notfound'),
                'data' => []
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.reviews_successfully'),
            'data' => $reviews  // نرسل الـ Paginator نفسه للـ Trait
        ];
    }
}
