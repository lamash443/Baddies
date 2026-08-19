<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
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
            'phone_number' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'sexual_orientation' => ['nullable', 'string', 'in:Straight,Gay,Lesbian,Bisexual,Other'],
            'age' => ['nullable', 'integer', 'min:18', 'max:100'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'county' => ['nullable', 'string', 'max:255'],
            'city_town' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'nearby_places' => ['nullable', 'string'],
            'services' => ['nullable', 'array'],
            'services.*' => ['string'],
            'other_services' => ['nullable', 'string'],
            'incalls_rate' => ['nullable', 'integer', 'min:0'],
            'outcalls_rate' => ['nullable', 'integer', 'min:0'],
            'other_cities' => ['nullable', 'string'],
            'favorites_visibility' => ['nullable', 'string', 'in:everybody,favourites,nobody'],
            'photos_visibility' => ['nullable', 'string', 'in:everybody,favourites,nobody'],
            'email_notifications' => ['nullable', 'string', 'in:messages,none'],
        ];
    }
}
