<?php

namespace App\Http\Requests\Api\v1\Events;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'long_description' => 'nullable|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(): array  {
        return [
            'title.required' => 'The event title is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title cannot be longer than 255 characters.',
        
            'long_description.string' => 'The description must be a valid string.',
        
            'event_date.required' => 'The event date is required.',
            'event_date.date' => 'Please provide a valid date format.',
        
            'event_time.required' => 'The event time is required.',
        
            'location.required' => 'The location is required.',
            'location.string' => 'The location must be a valid string.',
        
            'category_id.required' => 'Please select a category for the event.',
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }
}
