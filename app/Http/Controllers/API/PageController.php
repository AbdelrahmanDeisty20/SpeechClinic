<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\PageService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use ApiResponse;
    protected $pageService;
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }
    public function index()
    {
        $result = $this->pageService->getPages();
        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }
        return $this->success($result['data'], $result['message'], 200);
    }
}
