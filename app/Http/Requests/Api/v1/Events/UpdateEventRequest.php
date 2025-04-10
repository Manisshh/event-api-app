<?php

namespace App\Http\Requests\Api\v1\Events;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'date'          => 'required|date',
            'time'          => 'required',
            'location'      => 'required|string',
            'category_id'   => 'required|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'        => 'The title is required.',
            'title.string'          => 'The title must be a valid text.',
            'title.max'             => 'The title may not be greater than 255 characters.',

            'description.string'    => 'The description must be a valid text.',

            'date.required'         => 'Please provide a date.',
            'date.date'             => 'The date must be a valid date format.',

            'time.required'         => 'Please provide a time for the event.',

            'location.required'     => 'The location is required.',
            'location.string'       => 'The location must be a valid text.',

            'category_id.required'  => 'Please select a category.',
            'category_id.exists'    => 'The selected category is invalid.',
        ];
    }
}
