<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use App\Http\Controllers\Api\BaseController;

class ItemController extends BaseController
{
    protected ItemService $layananBarang;

    public function __construct(ItemService $layananBarang)
    {
        $this->layananBarang = $layananBarang;
    }

    public function index()
    {
        return $this->success($this->layananBarang->all(), 'Data semua barang berhasil diambil');
    }

    public function store(StoreItemRequest $request)
    {
        $barang = $this->layananBarang->create($request->validated());
        return $this->success($barang, "Barang berhasil dibuat", 201);
    }

    public function show($id)
    {
        try {
            $barang = $this->layananBarang->find($id);
            return $this->success($barang, 'Barang ditemukan');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function update(UpdateItemRequest $request, $id)
    {
        $barang = $this->layananBarang->update($id, $request->validated());
        return $this->success($barang, "Barang berhasil diperbarui");
    }

    public function destroy($id)
    {
        $this->layananBarang->delete($id);
        return $this->success(null, "Barang berhasil dihapus", 204);
    }
}