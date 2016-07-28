<?php

namespace Modules\Attribute\Normalisers;

final class AttributeOptionsNormaliser
{
    public function normalise(array &$options)
    {
        unset($options['count']);

        return $this->formatOptions($options);
    }

    private function formatOptions(array $options)
    {
        $cleaned = [];

        foreach ($options as $key => $option) {
            $value = $option['value'];
            unset($option['value']);
            foreach ($option as $locale => $item) {
                $cleaned[$value][$locale] = $item['label'];
            }
        }

        $cleaned = array_filter($cleaned, function ($value, $i) {
            return $i !== '' ? $value : '';
        }, ARRAY_FILTER_USE_BOTH);

        if (count($cleaned) === 0) {
            return null;
        }

        return $cleaned;
    }
}
