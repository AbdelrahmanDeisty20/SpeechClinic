<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ContactRequest;
use App\Services\API\ContactService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use ApiResponse;
    protected $contactService;
    public function __construct(ContactService $contactService)
    {
        $this->contactService=$contactService;
    }
    public function store(ContactRequest $request)
    {
        $result = $this->contactService->storeContact($request->validated());
        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }
        return $this->success($result['data'], $result['message'], 200);
    }
}
