<div class="form-group {{ $errors->has('attributes.' . $attribute->key) ? 'has-error' : '' }}">
    {!! Form::label($attribute->name, $attribute->name) !!}
    <input name="is_enabled" type="hidden" value="0" id="is_enabled">

    <?php foreach ($attribute->options as $key => $option): ?>
    <label class="checkbox">
        <input type="checkbox" name="attributes[{{ $attribute->key }}][]" class="flat-blue"
               value="{{ $key }}">
        {{ $option[locale()] }}
    </label>
    <?php endforeach; ?>
    {!! $errors->first('attributes.' . $attribute->key, '<span class="help-block">:message</span>') !!}
</div>
