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
                $cleaned[$value][$locale]['label'] = $item['label'];
            }
        }

        return $cleaned;
    }
}
