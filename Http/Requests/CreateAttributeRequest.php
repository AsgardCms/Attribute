<?php

namespace Modules\Attribute\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

final class CreateAttributeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'namespace' => 'required',
            'key' => 'required',
            'type' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'name' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function translationMessages()
    {
        return [
            'name.required' => trans('attribute::attributes.name is required'),
        ];
    }
}
