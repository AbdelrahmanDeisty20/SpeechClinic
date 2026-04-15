<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReviewRequest;
use App\Http\Resources\API\ReviewResource;
use App\Services\API\ReviewService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponse;
    protected $reviewService;
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    public function store(ReviewRequest $data)
    {
        $result = $this->reviewService->createReview($data->all());
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        } else {
            return $this->success($result['message'], $result['data']);
        }
    }
    public function index()
    {
        $result = $this->reviewService->getAllReviews();
        if (!$result['status']) {
            return $this->error($result['message'], 404);
        } else {
            return $this->paginated(ReviewResource::class, $result['data'], $result['message']);
        }
    }
}
