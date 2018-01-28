<?php

namespace Modules\Attribute\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

final class UpdateAttributeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'namespace' => 'required',
            'key' => 'required|unique:attribute__attributes,key,'.$this->route('attribute')->getKey().',id,namespace,'.$this->get('namespace'),
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

    public function messages()
    {
        return [
            'key.unique' => trans('attribute::attributes.key already exists'),
        ];
    }

    public function translationMessages()
    {
        return [
            'name.required' => trans('attribute::attributes.name is required'),
        ];
    }
}
