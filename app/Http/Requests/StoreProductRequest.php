<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|url|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'active' => 'required|boolean',
            'stockQuantity' => 'required|integer|min:0',
            'category' => 'nullable|integer|exists:categories,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
