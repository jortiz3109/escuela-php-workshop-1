<?php

namespace App\Http\Requests\Api\Developers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:10', 'max:120'],
            'email' => ['required', 'min:5', 'max:120', 'email:rfc,dns', Rule::unique('developers')],
        ];
    }
}
