<?php if ($oldOptions === null): ?>
    <?php $oldOptions = isset($attribute) ? $attribute->options : null; ?>
<?php endif; ?>
<?php if ($oldOptions !== null): ?>
    <?php $count = 1; ?>
    <?php foreach ($oldOptions as $value => $option): ?>
        <?php $count++; ?>
        @include('attribute::admin.attributes.partials.option_item', ['count' => $count])
    <?php endforeach; ?>
<?php endif; ?>
