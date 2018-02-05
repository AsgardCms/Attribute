<div class="form-group {{ $errors->has("attributes.{$attribute->slug}.$locale") ? 'has-error' : '' }}">
    {!! Form::label("attributes[$attribute->slug][$locale]", $attribute->name) !!}
    {!! Form::text("attributes[$attribute->slug][$locale]", old("attributes.{$attribute->slug}.$locale", $entity->findAttributeValueContent($attribute->slug, $locale)),
        [
            'class' => 'form-control',
            'data-slug' => $attribute->slug,
            'data-is-collection' => $attribute->isCollection()
        ]
    ) !!}
    {!! $errors->first("attributes.{$attribute->slug}.$locale", '<span class="help-block">:message</span>') !!}
</div>
