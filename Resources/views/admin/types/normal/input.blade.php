<div class="form-group {{ $errors->has('attributes.' . $attribute->key) ? 'has-error' : '' }}">
    {!! Form::label("attributes[][$attribute->key]", $attribute->name) !!}
    {!! Form::text("attributes[][$attribute->key]", old($attribute->key), ['class' => 'form-control']) !!}
    {!! $errors->first('attributes.' . $attribute->key, '<span class="help-block">:message</span>') !!}
</div>
