<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $inputan = $this->all();
        array_walk($inputan, function (&$nilai) {
            if (is_string($nilai)) {
                $nilai = trim(strip_tags($nilai));
            }
        });
        $this->merge($inputan);
    }

    public function rules()
    {
        return [
            "name" => "required|string|max:255",
            "quantity" => "required|integer|min:0",
            "price" => "required|numeric|min:0",
            "category_id" => "required|exists:categories,id",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Nama barang wajib diisi.",
            "quantity.integer" => "Jumlah harus angka bulat.",
            "price.numeric" => "Harga harus berupa angka.",
            "category_id.exists" => "Kategori tidak ditemukan di database.",
        ];
    }
}