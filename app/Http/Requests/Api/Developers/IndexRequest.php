<?php

namespace App\Http\Requests\Api\Developers;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filters' => ['filled', 'array'],
            'filters.email' => ['email'],
            'filters.name' => ['string', 'max:120'],
            'filters.enabled' => ['boolean'],
            'filters.enabled_at' => ['date_format:Y-m-d'],
        ];
    }
}
