<?php

namespace App\Repository;

use App\Models\Category;
use App\Repository\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index(): Collection
    {
        return Category::all();
    }

    public function store(array $data): Category
    {
        return Category::query()->create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    public function updatePhoto(Category $category, string $photoPath): Category
    {
        $category->update(['photo' => $photoPath]);
        return $category;
    }

    public function destroy(Category $category)
    {
        return $category->delete();
    }
}
