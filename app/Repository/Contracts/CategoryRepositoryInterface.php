<?php

namespace App\Repository\Contracts;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function index();
    public function store(array $data): Category;
    public function update(Category $category, array $data);
    public function updatePhoto(Category $category, string $photoPath): Category;
    public function destroy(Category $category);
}
