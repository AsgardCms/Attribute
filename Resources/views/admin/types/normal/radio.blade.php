<div class="form-group {{ $errors->has('attributes.' . $attribute->key) ? 'has-error' : '' }}">
    {!! Form::label($attribute->name, $attribute->name) !!}

    <?php foreach ($attribute->options as $key => $option): ?>
    <label class="radio">
        <input type="radio" name="attributes[{{ $attribute->key }}][]" class="flat-blue"
               value="{{ $key }}" {{ $entity->findAttributeValue($attribute->key, $key) ? 'checked' : '' }}>
        {{ $option[locale()] }}
    </label>
    <?php endforeach; ?>
    {!! $errors->first('attributes.' . $attribute->key, '<span class="help-block">:message</span>') !!}
</div>
