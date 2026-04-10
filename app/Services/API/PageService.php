<?php
namespace App\Services\API;

use App\Http\Resources\API\PageResource;
use App\Models\Page;

class PageService
{
    public function getPages()
    {
        $pages = Page::all();

        if ($pages->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.pages_notfound'),
                'data' => []
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.pages_successfully'),
            'data' => PageResource::collection($pages)
        ];
    }
}
