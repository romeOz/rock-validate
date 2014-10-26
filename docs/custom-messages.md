Custom messages, placeholders and templates 
==================

### Custom Messages

```php
use rock\validate\Validate as v;

$v = v::length(10, 20, true)
            ->messages(['length' => 'custom error']);
$v->validate('O’Reilly'); // output: false

$v->getErrors();
/*
output:

[
  'length' => 'custom error',
]
*/
```

### Custom Placeholders

```php
use rock\validate\Validate as v;

$v = v::length(10, 20, true)
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


### Custom Templates

```php
use rock\validate\Validate as v;

$v = v::length(10, 20, true)
            ->templates(['length' => Length::LOWER]);
$v->validate('O’Reilly'); // output: false

$v->getErrors();
/*
output:

[
  'length' => 'value must have a length greater than 10',
]
*/
```

> Typically, no need to change the template, because this is comes automatically, depending on the arguments specified. 
As an example see [Length](https://github.com/romeOz/rock-validate/blob/master/src/locale/en/Length.php).