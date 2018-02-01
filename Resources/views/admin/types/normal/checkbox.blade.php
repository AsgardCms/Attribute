<div class="form-group {{ $errors->has('attributes.' . $attribute->key) ? 'has-error' : '' }}">
    {!! Form::label($attribute->name, $attribute->name) !!}

    <?php foreach ($attribute->options as $key => $option): ?>
    <label class="checkbox">
        <input type="checkbox" name="attributes[{{ $attribute->key }}][]"
                class="flat-blue"
                data-key="{{ $attribute->key }}"
                data-is-collection="{{ $attribute->isCollection() }}"
                value="{{ $key }}" {{ $entity->findAttributeValue($attribute->key, $key) ? 'checked' : '' }}>
        {{ $option[locale()] }}
    </label>
    <?php endforeach; ?>
    {!! $errors->first('attributes.' . $attribute->key, '<span class="help-block">:message</span>') !!}
</div>
