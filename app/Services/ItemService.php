<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Log;

class ItemService
{
    public function all()
    {
        return Item::all();
    }

    public function find($id)
    {
        return Item::findOrFail($id);
    }

    public function create(array $data)
    {
        $barang = Item::create($data);
        Log::info('Barang baru berhasil ditambahkan: ' . $barang->name);
        return $barang;
    }

    public function update($id, array $data)
    {
        $barang = Item::findOrFail($id);
        $barang->update($data);
        Log::info('Data barang berhasil diperbarui untuk ID: ' . $id);
        return $barang;
    }

    public function delete($id)
    {
        $barang = Item::findOrFail($id);
        $barang->delete();
        Log::info('Barang berhasil dihapus dengan ID: ' . $id);
        return true;
    }
}