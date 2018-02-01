<?php

namespace Modules\Attribute\Types;

final class MultiSelectType extends BaseType
{
    protected $identifier = 'multiselect';
    protected $useOptions = true;
    protected $isCollection = true;
}
