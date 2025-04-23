<?php
namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StepOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'step' => 'required|string|in:lanche,bebida,acompanhamento,sobremesa',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ];
    }
}
