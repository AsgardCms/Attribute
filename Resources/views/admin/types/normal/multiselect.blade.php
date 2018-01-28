<div class="form-group {{ $errors->has('attributes.' . $attribute->key) ? 'has-error' : '' }}">
    {!! Form::label($attribute->name, $attribute->name) !!}

    <select name="attributes[{{ $attribute->key }}][]" class="form-control jsOptionLanguage" multiple>
        <?php foreach ($attribute->options as $key => $option): ?>
        <option value="{{ $key }}" {{ $entity->findAttributeValue($attribute->key, $key) ? 'selected' : '' }}>{{ $option[locale()] }}</option>
        <?php endforeach; ?>
    </select>

    {!! $errors->first('attributes.' . $attribute->key, '<span class="help-block">:message</span>') !!}
</div>
