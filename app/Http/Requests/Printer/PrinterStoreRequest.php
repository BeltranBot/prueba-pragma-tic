<?php

namespace App\Http\Requests\Printer;

use Illuminate\Foundation\Http\FormRequest;

class PrinterStoreRequest extends FormRequest
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
        return [
            'model' => 'required',
            'prep_time' => 'required|numeric',
            'max_width' => 'required|numeric',
            'printing_speed' => 'required|numeric',
        ];
    }
}
