<?php
namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'cpf' => 'required|string|max:14',
            'phone' => 'required|string|max:15',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
