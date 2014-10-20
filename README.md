Validator for PHP
=======================

[![Latest Stable Version](https://poser.pugx.org/romeOz/rock-validate/v/stable.svg)](https://packagist.org/packages/romeOz/rock-validate)
[![Total Downloads](https://poser.pugx.org/romeOz/rock-validate/downloads.svg)](https://packagist.org/packages/romeOz/rock-validate)
[![Build Status](https://travis-ci.org/romeOz/rock-validate.svg?branch=master)](https://travis-ci.org/romeOz/rock-validate)
[![Coverage Status](https://coveralls.io/repos/romeOz/rock-validate/badge.png?branch=master)](https://coveralls.io/r/romeOz/rock-validate?branch=master)
[![License](https://poser.pugx.org/romeOz/rock-validate/license.svg)](https://packagist.org/packages/romeOz/rock-validate)

[Rock validator on Packagist](https://packagist.org/packages/romeOz/rock-validate)

Features
-------------------

 * Supports large many validation rules (string, number, ctype, file, network)
 * Validation of scalar variable and array (`allOf`, `oneOf`)
 * **Output the list of errors in an associative array**
 * **i18n support**
 * **Hot replacement of placeholders for messages (`{{name}} must be valid`), as well messages**
 * **Customization of validation rules**

> Bolded features are different from [Respect/Validation](https://github.com/Respect/Validation).

Installation
-------------------

From the Command Line:

```composer require romeoz/rock-validate:*```

In your composer.json:

```json
{
    "require": {
        "romeoz/rock-validate": "*"
    }
}
```

Quick Start
-------------------

```php
use rock\validate\Validate;

$v = Validate::length(10, 20, true)->regex('/^[a-z]+$/i');
$v->validate('O’Reilly'); // output: false

$v->getErrors();
/*
output:

[
  'length' => 'value must have a length between 10 and 20',
  'regex' => 'value contains invalid characters'
]
*/

$v->getFirstError();
// output: value must have a length between 10 and 20
```

###Replacement of placeholder

```php
use rock\validate\Validate;

$v = Validate::length(10, 20, true)
            ->regex('/^[a-z]+$/i')
            ->placeholders(['name' => 'username']);
$v->validate('O’Reilly'); // output: false

$v->getErrors();
/*
output:

[
  'length' => 'username must have a length between 10 and 20',
  'regex' => 'username contains invalid characters',
]
*/
```

###i18n

```php
use rock\validate\Validate;

$v = Validate::locale(Validate::RU)->length(10, 20, true)->regex('/^[a-z]+$/i');
$v->validate('O’Reilly'); // output: false

$v->getErrors();
/*
output:

[
  'length' => 'значение должно иметь длину в диапазоне от 10 до 20',
  'regex' => 'значение содержит неверные символы',
]
*/
```

### AllOf (Array or Object)
```php
use rock\validate\Validate;

$input = [
    'username' => 'O’Reilly',
    'email' => 'o-reilly@site'
];
$v = Validate::allOf(
    [
        'username' => Validate::required()
            ->length(10, 20, true)
            ->regex('/^[a-z]+$/i')
            ->placeholders(['name' => 'username']),
        
        'email' => Validate::required()->email()
    ]
);
$v->validate($input); // output false

$v->getErrors();
/*
output:

[
  'username' => 
  [
    'length' => 'username must have a length between 10 and 20',
    'regex' => 'username contains invalid characters',
  ],
  'email' => 
      [
        'email' => 'email must be valid email',
      ]
]
*/

$attribute = 'email';
$v->getFirstError($attribute);
// output: email must be valid
```

Documentation
-------------------
**TODO**

Requirements
-------------------

 * **PHP 5.4+**

License
-------------------

The Rock Validator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).