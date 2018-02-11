<?php

namespace Modules\Attribute\Types;

final class CheckboxType extends BaseType
{
    protected $identifier = 'checkbox';
    protected $useOptions = true;
    protected $isCollection = true;
}
