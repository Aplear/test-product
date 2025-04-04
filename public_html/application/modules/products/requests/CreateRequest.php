<?php

namespace App\modules\products\requests;

use App\FormRequest;

class CreateRequest extends FormRequest
{

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'uuid'           => 'required',
            'name'           => 'required',
            'category'       => 'required',
            'price'          => 'required',
        ];
    }
}
