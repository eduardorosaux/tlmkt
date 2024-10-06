<?php

namespace App\Http\Requests\Client;

use App\Rules\UniquePhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContactsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $client_id = Auth::user()->client->id;

        return [
            'phone'      => ['required', 'string', 'min:11', new UniquePhoneNumber($client_id)],
            'country_id' => 'nullable|exists:countries,id',
            'name' => 'required|string'

        ];
    }
}
