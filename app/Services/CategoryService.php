<?php

namespace App\Services;

use App\Models\Category;
use App\Repository\Contracts\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryService implements CategoryServiceInterface
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index(): Collection
    {
        return $this->categoryRepository->index();
    }

    public function store(Request $request): Category
    {
        $data = $request->except('photo');

        # salvo il record nel repository class e poi il file
        $category =  $this->categoryRepository->store($data);

        #Salvo il file usando id del record
        if($request->hasFile('photo')){
            $filePath = $this->handleFileUpload($request->file('photo'), $category->id);
            $category = $this->categoryRepository->updatePhoto($category, $filePath);
        }
        return $category;
    }

    public function update(Category $category, Request $request): Category
    {
        $data = $request->except('photo'); # Esclude la foto dall'update iniziale
        $updatedCategory = $this->categoryRepository->update($category, $data);

        if ($request->hasFile('photo')) {
            $filePath = $this->handleFileUpload($request->file('photo'), $category->id, $category->photo);
            $updatedCategory = $this->categoryRepository->updatePhoto($updatedCategory, $filePath);
        }

        return $updatedCategory;
    }

    public function destroy(Category $category):bool
    {
        if ($category->photo && Storage::exists($category->photo)) {
            Storage::delete($category->photo);
        }
        return $this->categoryRepository->destroy($category);
    }

    private function handleFileUpload($file, int $categoryId, string $oldFilePath = null): string
    {
        if ($oldFilePath && Storage::exists($oldFilePath)) {
            Storage::delete($oldFilePath);
        }

        $filePath = 'categories/' . $categoryId . '.' . $file->extension();
        $file->storePubliclyAs($filePath);

        return $filePath;
    }

}
