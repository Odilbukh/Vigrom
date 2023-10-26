<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'currency' => 'required|string|in:RUB,USD',
            'reason' => 'required|string|in:stock,refund',
            'transaction_type' => 'required|string|in:debit,credit',
            'wallet_id' => 'required|exists:wallets,id,deleted_at,NULL',
        ];
    }
}
