<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string|in:asset,investment,asset',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'The selected user does not exist.',
            'account_name.required' => 'Account name is required.',
            'account_type.required' => 'Account type is required.',
            'account_type.in' => 'Account type must be one of: asset, liability, equity, revenue, expense.',
        ];
    }
}

