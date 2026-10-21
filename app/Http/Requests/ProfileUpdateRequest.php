<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $input = $this->all();
        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                $value = preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{2300}-\x{23FF}]/u', '', $value);
            }
        });
        $this->merge($input);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // Digits, +, spaces, hyphens only — max 15
            'phone_number'       => ['nullable', 'string', 'max:15', 'regex:/^[0-9+\s\-]*$/'],
            'gender'             => ['nullable', 'string', 'in:Male,Female,Other'],
            'sexual_orientation' => ['nullable', 'string', 'in:Straight,Gay,Lesbian,Bisexual,Other'],
            'age'                => ['nullable', 'integer', 'min:18', 'max:100'],
            // Letters, spaces, hyphens, apostrophes — max 30
            'nationality'        => ['nullable', 'string', 'max:30', 'regex:/^[\p{L}\s\'\-]*$/u'],
            'county'             => ['required', 'string', 'max:50', 'regex:/^[\p{L}\p{N}\s\'\-]+$/u'],
            'city_town'          => ['nullable', 'string', 'max:30', 'regex:/^[\p{L}\s\'\-]*$/u'],
            'location'           => ['required', 'string', 'max:50', 'regex:/^[\p{L}\p{N}\s\'\-]+$/u'],
            'area'               => ['nullable', 'string', 'max:30', 'regex:/^[\p{L}\s\'\-]*$/u'],
            // Letters, spaces, commas, hyphens, periods — max 200
            'nearby_places'      => ['nullable', 'string', 'max:200', 'regex:/^[\p{L}\s,.\-]*$/u'],
            'services'           => ['nullable', 'array'],
            'services.*'         => ['string'],
            // Letters, spaces, commas, hyphens — max 100
            'other_services'     => ['nullable', 'string', 'max:100', 'regex:/^[\p{L}\s,\-]*$/u'],
            'incalls_rate'       => ['nullable', 'integer', 'min:0', 'max:999999'],
            'outcalls_rate'      => ['nullable', 'integer', 'min:0', 'max:999999'],
            // Letters, spaces, commas, hyphens — max 100
            'other_cities'       => ['nullable', 'string', 'max:100', 'regex:/^[\p{L}\s,\-]*$/u'],
            'favorites_visibility' => ['nullable', 'string', 'in:everybody,favourites,nobody'],
            'photos_visibility'    => ['nullable', 'string', 'in:everybody,favourites,nobody'],
            'email_notifications'  => ['nullable', 'string', 'in:messages,none'],
            'calls_enabled'        => ['boolean'],
            'is_profile_hidden'    => ['boolean'],
        ];

    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'age.min'                    => 'You must be at least 18 years old.',
            'age.max'                    => 'Age cannot exceed 100 years.',
            'age.integer'                => 'Please enter a valid age.',
            'phone_number.max'           => 'Phone number cannot exceed 15 characters.',
            'phone_number.regex'         => 'Phone number may only contain digits, +, spaces and hyphens.',
            'nationality.max'            => 'Nationality cannot exceed 30 characters.',
            'nationality.regex'          => 'Nationality may only contain letters and spaces — no punctuation or emojis.',
            'county.required'            => 'Please select or specify your county.',
            'county.max'                 => 'County cannot exceed 50 characters.',
            'county.regex'               => 'County may only contain letters, numbers, spaces, and hyphens.',
            'city_town.max'              => 'City/Town cannot exceed 30 characters.',
            'city_town.regex'            => 'City/Town may only contain letters, spaces and hyphens.',
            'location.required'          => 'Please select or specify your location.',
            'location.max'               => 'Location cannot exceed 50 characters.',
            'location.regex'             => 'Location may only contain letters, numbers, spaces, and hyphens.',
            'area.max'                   => 'Area cannot exceed 30 characters.',
            'area.regex'                 => 'Area may only contain letters, spaces and hyphens.',
            'nearby_places.max'          => 'Nearby places cannot exceed 200 characters.',
            'nearby_places.regex'        => 'Nearby places may only contain letters, spaces, commas and hyphens.',
            'other_services.max'         => 'Other services cannot exceed 100 characters.',
            'other_services.regex'       => 'Other services may only contain letters, spaces and commas.',
            'other_cities.max'           => 'Other cities cannot exceed 100 characters.',
            'other_cities.regex'         => 'Other cities may only contain letters, spaces and commas.',
            'incalls_rate.max'           => 'Incalls rate cannot exceed 999,999 Ksh.',
            'outcalls_rate.max'          => 'Outcalls rate cannot exceed 999,999 Ksh.',
        ];
    }
}
