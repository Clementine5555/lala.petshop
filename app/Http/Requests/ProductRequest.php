<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
	public function authorize()
	{
		$user = $this->user();
		return $user && in_array($user->role, ['admin', 'superadmin']);
	}

	public function rules()
	{
		return [
			'supplier_id' => ['nullable', 'integer', 'exists:suppliers,supplier_id'],
			'name' => ['required', 'string', 'max:200'],
			'category' => ['nullable', 'string', 'max:100'],
			'description' => ['nullable', 'string'],
			'price' => ['required', 'numeric'],
			'stock' => ['required', 'integer', 'min:0'],
		];
	}

	public function messages()
	{
		return [
			'name.required' => 'Product name is required.',
			'price.required' => 'Price is required.',
			'stock.required' => 'Stock is required.',
			'supplier_id.exists' => 'Selected supplier does not exist.',
		];
	}
}

