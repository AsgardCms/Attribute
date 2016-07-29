<div class="form-group {{ $errors->has("attributes.{$attribute->key}.$locale") ? 'has-error' : '' }}">
    {!! Form::label("attributes[$attribute->key][$locale]", $attribute->name) !!}
    {!! Form::text("attributes[$attribute->key][$locale]", old($attribute->key), ['class' => 'form-control']) !!}
    {!! $errors->first("attributes.{$attribute->key}.$locale", '<span class="help-block">:message</span>') !!}
</div>
