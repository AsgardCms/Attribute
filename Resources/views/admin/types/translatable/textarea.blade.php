<div class="form-group {{ $errors->has("attributes.{$attribute->key}.$locale") ? 'has-error' : '' }}">
    {!! Form::label("attributes[$attribute->key][$locale]", $attribute->name) !!}
    {!! Form::textarea("attributes[$attribute->key][$locale]", old($attribute->key, $entity->findAttributeValueContent($attribute->key, $locale)),
        [
            'class' => 'form-control',
            'data-key' => $attribute->key,
            'data-is-collection' => $attribute->isCollection()
        ]
    ) !!}
    {!! $errors->first("attributes.{$attribute->key}.$locale", '<span class="help-block">:message</span>') !!}
</div>
