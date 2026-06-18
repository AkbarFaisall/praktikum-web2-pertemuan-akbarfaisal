<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use App\Http\Controllers\Api\BaseController;

class CategoryController extends BaseController
{
    protected CategoryService $layananKategori;

    public function __construct(CategoryService $layananKategori)
    {
        $this->layananKategori = $layananKategori;
    }

    public function index()
    {
        
        return $this->success($this->layananKategori->all(), 'datanya udah ditarik semua');
    }

    public function store(StoreCategoryRequest $request)
    {
        $kategori = $this->layananKategori->create($request->validated());
        return $this->success($kategori, "Kategori dibuat", 201);
    }

    public function show($id)
    {
        try {
            $kategori = $this->layananKategori->find($id);
            return $this->success($kategori, 'Kategori ditemukan');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $kategori = $this->layananKategori->update($id, $request->validated());
        return $this->success($kategori, "Kategori diperbarui");
    }

    public function destroy($id)
    {
        $this->layananKategori->delete($id);
        return $this->success(null, "Kategori dihapus", 204);
    }
}