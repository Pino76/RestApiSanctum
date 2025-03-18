<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Contracts\CategoryServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    private CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->index();
        return response()->json([
            "status" => Response::HTTP_OK,
            "count" => $categories->count(),
            "data" => CategoryResource::collection($categories)
        ], Response::HTTP_OK );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->store($request);

        return response()->json([
            "status" => Response::HTTP_CREATED,
            "data" => new CategoryResource($category)
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category): JsonResponse
    {
        $updatedCategory = $this->categoryService->update($category, $request);

        return response()->json([
            "status" => Response::HTTP_OK,
            "data" => new CategoryResource($updatedCategory),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $deleted = $this->categoryService->destroy($category);
        return response()->json([
            "message" => $deleted ? "Record cancellato" : "Errore nella cancellazione",
            "status" => $deleted ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR,
        ], $deleted ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
