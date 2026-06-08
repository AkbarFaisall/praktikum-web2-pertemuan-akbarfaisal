<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            "name" => "sometimes|required|string|max:255",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Nama kategori wajib diisi.",
        ];
    }
}