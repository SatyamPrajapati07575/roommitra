<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'room_number' => 'nullable|string|max:50',
            'room_title' => 'required|string|max:255',
            'room_description' => 'required|string',
            'room_price' => 'required|numeric|min:500',
            'security_deposit' => 'required|numeric|min:0',
            'min_stay_months' => 'required|integer|min:1|max:24',
            
            'room_capacity' => 'required|integer|min:1',
            'total_beds' => 'required|integer|min:1',
            'floor' => 'nullable|integer|min:0',
            
            // Amenities (checkboxes - optional)
            'ac' => 'nullable',
            'lift' => 'nullable',
            'parking' => 'nullable',
            
            // Kitchen & Bathroom
            'kitchen_type' => 'required|string|in:private,shared,none',
            'bathroom_type' => 'required|string|in:attached,common',
            
            // Location
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'locality' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|digits:6',
            
            // Optional fields
            'entry_time' => 'nullable|date_format:H:i',
            'exit_time' => 'nullable|date_format:H:i',
            'restrictions' => 'nullable|string|max:500',
            
            // Images - optional in edit (only if uploaded)
            'room_images' => 'nullable|array',
            'room_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'room_title.required' => 'Room title is required.',
            'room_title.max' => 'Room title must not exceed 255 characters.',
            
            'room_description.required' => 'Room description is required.',
            
            'room_price.required' => 'Room price is required.',
            'room_price.numeric' => 'Room price must be a number.',
            'room_price.min' => 'Room price must be at least ₹500.',
            
            'security_deposit.required' => 'Security deposit is required.',
            'security_deposit.numeric' => 'Security deposit must be a number.',
            
            'min_stay_months.required' => 'Minimum stay months is required.',
            'min_stay_months.integer' => 'Minimum stay months must be a number.',
            'min_stay_months.min' => 'Minimum stay must be at least 1 month.',
            'min_stay_months.max' => 'Minimum stay must not exceed 24 months.',
            
            'room_capacity.required' => 'Room capacity is required.',
            'room_capacity.integer' => 'Room capacity must be a number.',
            'room_capacity.min' => 'Room capacity must be at least 1.',
            
            'total_beds.required' => 'Total beds is required.',
            'total_beds.integer' => 'Total beds must be a number.',
            'total_beds.min' => 'Total beds must be at least 1.',
            
            'kitchen_type.required' => 'Kitchen type is required.',
            'kitchen_type.in' => 'Kitchen type must be Private, Shared, or None.',
            
            'bathroom_type.required' => 'Bathroom type is required.',
            'bathroom_type.in' => 'Bathroom type must be Attached or Common.',
            
            'address_line1.required' => 'Address line 1 is required.',
            'address_line1.max' => 'Address line 1 must not exceed 255 characters.',
            
            'locality.required' => 'Locality is required.',
            'locality.max' => 'Locality must not exceed 100 characters.',
            
            'city.required' => 'City is required.',
            'city.max' => 'City must not exceed 100 characters.',
            
            'state.required' => 'State is required.',
            'state.max' => 'State must not exceed 100 characters.',
            
            'pincode.required' => 'Pincode is required.',
            'pincode.digits' => 'Pincode must be exactly 6 digits.',
            
            'entry_time.date_format' => 'Entry time must be in HH:MM format.',
            'exit_time.date_format' => 'Exit time must be in HH:MM format.',
            
            'room_images.*.image' => 'Each file must be an image.',
            'room_images.*.mimes' => 'Images must be JPEG, PNG, or JPG format.',
            'room_images.*.max' => 'Each image must not exceed 2MB.',
        ];
    }
}
