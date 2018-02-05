<?php

namespace Modules\Attribute\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

final class UpdateAttributeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => 'required',
            'slug' => 'required|unique:attribute__attributes,slug,'.$this->route('attribute')->getKey().',id,namespace,'.$this->get('namespace'),
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
            'type.required' => trans('attribute::attributes.type is required'),
            'slug.unique' => trans('attribute::attributes.slug already exists'),
        ];
    }

    public function translationMessages()
    {
        return [
            'name.required' => trans('attribute::attributes.name is required'),
        ];
    }
}
