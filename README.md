# Laraplug Attribute

**Laraplug Attribute** is a EAV e-commerce module, built on top of [AsgardCMS](https://github.com/AsgardCms/Platform) platform.

Successfully implemented on [laraplug/product-module](https://github.com/laraplug/product-module)

## Table Of Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Add EAV to Eloquent model](#add-eav-to-eloquent-model)
    - [Configure attributes on Eloquent model](#configure-attributes-on-eloquent-model)
- [About Laraplug](#about-laraplug)
- [Contributing](#contributing)

## Installation

1. Install the package via composer:
    ```shell
    composer require laraplug/attribute-module
    ```

2. Execute migrations via [AsgardCMS](https://github.com/AsgardCms/Platform)'s module command:
    ```shell
    php artisan module:migrate Attribute
    ```

3. Execute publish via [AsgardCMS](https://github.com/AsgardCms/Platform)'s module command:
    ```shell
    php artisan module:publish Attribute
    ```

4. Done!


## Usage

### Add EAV to Eloquent model

To add EAV functionality to your Eloquent model, just use the `\Module\Attribute\Traits\Attributable` trait and implement `\Module\Attribute\Contracts\AttributesInterface`like this:

```php
use \Module\Attribute\Contracts\AttributesInterface
use \Module\Attribute\Traits\Attributable

class Book extends Model implements AttributesInterface
{
    use Attributable;
}
```

### Configure attributes on Eloquent model

Add `$systemAttributes` on your entity to add attributes on code-level:

```php
use \Module\Attribute\Contracts\AttributesInterface
use \Module\Attribute\Traits\Attributable

class Book extends Model implements AttributesInterface
{
    use Attributable;
    ...

    // Set systemAttributes to define EAV attributes
    protected static $systemAttributes = [
        'isbn' => [
            'type' => 'input'
        ],
        'media' => [
            'type' => 'checkbox',
            'options' => [
                'audio-cd',
                'audio-book',
                'e-book',
            ]
        ]
    ];
}
```

#### Available SystemAttributes Parameters

**type** : String of input type (list below)
 - `input` : input[type=text]
 - `textarea` : teaxarea
 - `radio` : input[type=radio]
 - `checkbox` : input[type=checkbox]
 - `select` : select
 - `multiselect` : select[multiple]

**options** : Array of option keys

**has_translatable_values** : boolean

### About Laraplug

LaraPlug is a opensource e-commerce project built on top of AsgardCMS.


## Contributing

We welcome any pull-requests or issues :)
