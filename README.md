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
 * Validation of scalar variable and array (`attributes()`, `attributesOne()`)
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

// Validation length from 10 to 20 characters inclusive + regexp pattern
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

####Replacement of placeholder

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

####i18n

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

####For Array or Object

```php
use rock\validate\Validate;

$input = [
    'username' => 'O’Reilly',
    'email' => 'o-reilly@site'
];
$attributes = [
  'username' => Validate::required()
      ->length(10, 20, true)
      ->regex('/^[a-z]+$/i')
      ->placeholders(['name' => 'username']),
  
  'email' => Validate::required()->email()
];

$v = Validate::attributes($attributes);
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

 * [Rules](https://github.com/romeOz/rock-validate/blob/master/docs/rules.md)
 * [Custom messages, placeholders and templates](https://github.com/romeOz/rock-validate/blob/master/docs/custom-messages.md)
 * [Custom rules](https://github.com/romeOz/rock-validate/blob/master/docs/custom-rules.md)

Demo & Tests
-------------------

Use a specially prepared environment (Vagrant + Ansible).

###Out of the box:

 * Ubuntu 14.04 64 bit

> If you need to use 32 bit of Ubuntu, then uncomment `config.vm.box_url` the appropriate version in the file `/path/to/Vagrantfile`.

 * Nginx 1.6
 * PHP-FPM 5.6
 * Composer
 * Local IP loop on Host machine /etc/hosts and Virtual hosts in Nginx already set up!

###Installation:

1. [Install Composer](https://getcomposer.org/doc/00-intro.md#globally)
2. ```composer create-project --prefer-dist romeoz/rock-validate```
3. [Install Vagrant](https://www.vagrantup.com/downloads), and additional Vagrant plugins ```vagrant plugin install vagrant-hostsupdater vagrant-vbguest vagrant-cachier```
4. ```vagrant up```
5. Open demo [http://rock.validate/](http://rock.validate/) or [http://192.168.33.35/](http://192.168.33.35/)

> Work/editing the project can be done via ssh:
```bash
vagrant ssh
cd /var/www/
```

Requirements
-------------------

 * **PHP 5.4+**

License
-------------------

The Rock Validator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).