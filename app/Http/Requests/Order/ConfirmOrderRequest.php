<?php
namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'nullable|exists:clients,id',
            'origin' => 'nullable|in:totem,whatsapp,balcao',
        ];
    }
}
