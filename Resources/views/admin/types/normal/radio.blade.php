<div class="form-group {{ $errors->has('attributes.' . $attribute->slug) ? 'has-error' : '' }}">
    {!! Form::label($attribute->name, $attribute->name) !!}

    <?php foreach ($attribute->options as $key => $option): ?>
    <label class="radio">
        <input type="radio" name="attributes[{{ $attribute->slug }}]"
                class="flat-blue"
                data-slug="{{ $attribute->slug }}"
                data-is-collection="{{ $attribute->isCollection() }}"
                value="{{ $key }}" {{ $entity->findAttributeValue($attribute->slug, $key) ? 'checked' : '' }}>
        {{ $option->getLabel() }}
    </label>
    <?php endforeach; ?>
    {!! $errors->first('attributes.' . $attribute->slug, '<span class="help-block">:message</span>') !!}
</div>
