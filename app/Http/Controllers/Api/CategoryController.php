<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->categoryService = new CategoryService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParentCategories(){
        try {
            $categories = $this->categoryService->getCategoriesListing(null);
            $response = CategoryResource::collection($categories);
            return response()->json([
                'status'=>'success',
                'status_code'=>200,
                'data'=>['categories'=>$response]
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>'fail',
                'status_code'=>$exception->getCode(),
                'data'=>$exception->getMessage()
            ],500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChildCategories(Request $request){
        $request->validate([
            'category_id'=>'required'
        ]);
        try {
            $categories = $this->categoryService->getCategoriesListing($request->all());
            $response = CategoryResource::collection($categories);
            return response()->json([
                'status'=>'success',
                'status_code'=>200,
                'data'=>['categories'=>$response]
            ],200);
        }catch (\Exception $exception){
            return response()->json([
                'status'=>'fail',
                'status_code'=>$exception->getCode(),
                'data'=>$exception->getMessage()
            ],500);
        }
    }
}
