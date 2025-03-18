<?php

namespace App\Services\Contracts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface CategoryServiceInterface
{
    public function index(): Collection;
    public function store(Request $request): Category;
    public function update(Category $category, Request $request): Category;
    public function destroy(Category $category): bool;
}
