<?php

namespace Modules\Attribute\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

final class CreateAttributeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'namespace' => 'required',
            'slug' => 'required|unique:attribute__attributes,slug,NULL,id,namespace,'.$this->get('namespace'),
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
