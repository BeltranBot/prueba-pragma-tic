<?php

namespace App\Http\Requests\Pricing;

use Illuminate\Foundation\Http\FormRequest;

class StorePricingRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $printing_type_id = request('printing_type_id');

        $rules = [
            'printing_type_id' => 'required|exists:printing_types,id',
            'client_id' => 'required|exists:clients,id',
            'printer_id' => 'required|exists:printers,id',
            'operator_id' => 'required|exists:operators,id',
            'paper_id' => 'required|exists:papers,id',

            'tag_width' => 'required|numeric',
            'tag_height' => 'required|numeric',
            'paper_cost' => 'required|numeric',
            'printing_time' => 'required|numeric',
        ];

        if ($printing_type_id === 2) {
            $rules['wasted_paper'] = 'required|numeric';
            $rules['inks_number'] = 'required|numeric';
        }

        return $rules;
    }
}
