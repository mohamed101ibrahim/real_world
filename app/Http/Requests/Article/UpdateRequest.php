<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('article')->user->id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'body' => 'sometimes|string|max:2048',
            'tagList' => 'sometimes|array',
            'tagList.*' => 'sometimes|string|max:255'
        ];
    }


}