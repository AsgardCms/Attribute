<div class="form-group {{ $errors->has($attribute->key) ? 'has-error' : '' }}">
    {!! Form::label($attribute->key, $attribute->name) !!}
    {!! Form::textarea($attribute->key, old($attribute->key), ['class' => 'form-control']) !!}
    {!! $errors->first($attribute->key, '<span class="help-block">:message</span>') !!}
</div>
