Rules
==================

> Documentation with some modifications taken from [Respect/Validation](https://github.com/Respect/Validation).

### [Generics](#generics)

 * [v::allOf()](#vallof)
 * [v::notOf()](#vnotof)
 * [v::oneOf()](#voneof)
 * [v::when()](#vwhenv-if-v-then-v-else)
  
### [Comparing Values](#comparing-values)

 * [v::between()](#vbetweenmin-max)
 * [v::confirm()](#vconfirm)
 * [v::equals()](#vequalsvalue)
 * [v::max()](#vmax)
 * [v::min()](#vmin)

### [Types](#types)

 * [v::arr()](#varr)
 * [v::bool()](#vbool)
 * [v::closure()](#vclosure)
 * [v::date()](#vdate)
 * [v::float()](#vfloat)
 * [v::int()](#vint)
 * [v::required()](#vrequired)
 * [v::nullValue()](#vnullvalue)
 * [v::numeric()](#vnumeric)
 * [v::object()](#vobject)
 * [v::string()](#vstring)
  
### [CTypes](#ctypes)  

 * [v::alnum()](#valnum)
 * [v::alpha()](#valpha)
 * [v::cntrl()](#vcntrl)
 * [v::digit()](#vdigit)
 * [v::graph()](#vgraph)
 * [v::space()](#vspace)

### [Numeric](#numeric)

 * [v::between()](#vbetweenmin-max)
 * [v::bool()](#vbool)
 * [v::float()](#vfloat)
 * [v::int()](#vint)
 * [v::negative()](#vnegative)
 * [v::numeric()](#vnumeric)
 * [v::odd()](#vodd)
 * [v::positive()](#vpositive)
 * [v::digit()](#vdigit)

### [String](#string)

 * [v::alnum()](#valnum)
 * [v::alpha()](#valpha)
 * [v::between()](#vbetweenmin-max)
 * [v::contains()](#vcontainsvalue)
 * [v::cntrl()](#vcntrl)
 * [v::digit()](#vdigit)
 * [v::email()](#vemail)
 * [v::endsWith()](#vendswithvalue)
 * [v::graph()](#vgraph)
 * [v::in()](#vinhaystack)
 * [v::json()](#vjson)
 * [v::length()](#vlengthmin-max)
 * [v::lowercase()](#vlowercase)
 * [v::noWhitespace()](#vnowhitespace)
 * [v::regex()](#vregexregex)
 * [v::required()](#vrequired)
 * [v::space()](#vspace)
 * [v::startsWith()](#vstartswithvalue)
 * [v::uppercase()](#vuppercase)

### Arrays

 * [v::arr()](#varr)
 * [v::contains()](#vcontainsvalue)
 * [v::endsWith()](#vendswithvalue)
 * [v::in()](#vinhaystack)
 * [v::length()](#vlengthmin-max)
 * [v::required()](#vrequired)
 * [v::startsWith()](#vstartswithvalue)

### Objects

 * [v::object()](#vobject)

### Date and Time

 * [v::between()](#vbetweenmin-max)
 * [v::date()](#vdate)

### [Files](#files)

 * [v::directory()](#vdirectory)
 * [v::exists)](#vexists)
 * [v::file()](#vfile)
 * [v::readable()](#vreadable)
 * [v::symbolicLink()](#vsymboliclink)
 * [v::uploaded()](#vuploaded)
 * [v::writable()](#vwritable)

### [Network](#network)

 * [v::domain()](#vdomain)
 * [v::ip()](#vip)
  
### [Other](#other)

 * [v::call()](#vcall)

### [Custom rules](custom-rules.md)


### Generics

#### v::allOf(['attribute_1' => $v1, 'attribute_2' => $v2, 'attribute_3' => $v3,... ])
	
For arrays and objects. Will validate if all inner validators of attributes valid.

```php
$input = [
    'username' => 'O’Reilly',
    'email' => 'o-reilly@site'
];
$attributes = [
  'username' => v::required()
      ->length(10, 20, true)
      ->regex('/^[a-z]+$/i'),
  
  'email' => v::required()->email()
];

$v = v::allOf($attributes);
$v->validate($input); // output false
```
Syntax allows you to set custom placeholders for every node:

```php
$input = [
    'username' => 'O’Reilly',
    'email' => 'o-reilly@site'
];
$attributes = [
  'username' => v::required()
      ->length(10, 20, true)
      ->regex('/^[a-z]+$/i')
      ->placeholders(['name' => 'username']),
  
  'email' => v::required()
                ->email()
                ->placeholders(['name' => 'email']),
];

$v = v::allOf($attributes);
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
```

#### v::oneOf(['attribute_1' => $v1, 'attribute_2' => $v2, 'attribute_3' => $v3,... ])

This is a group validator that acts as an OR operator (if only one condition is valid).

```php
$input =  [
    'email' => 'tom@site',
    'username' => ''
];
$v = v::oneOf(
    [
        'email' => v::email(),
        'username' => v::required()
    ]
);
$v->validate($input); // output: false

$v->getErrors();
/*
output:

[
  'email' => 
  [
    'email' => 'email must be valid',
  ]
]
*/
```

#### v::notOf($v)

Negates any rule (invert validation).

```php
$v = v::notOf(v::required());
$v->validate(''); // output: true
```

For `allOf`:

```php
$input =  [
    'email' => 'tom@site',
    'username' => ''
];
$v = v::notOf(
    v::allOf(
        [
            'email' => v::email(),
            'username' => v::required()
        ]
    )
);
$v->validate($input); // output: true
```

#### v::when(v $if, v $then, v $else = null)

A ternary validator that accepts three parameters.

When the $if validates, returns validation for `$then`.
When the $if doesn't validate, returns validation for `$else`.

> If `$else` equals `null`, then returns `true`.

```php
$v = v::when(v::equals('5'), v::string());
$v->validate(5); // output false

$v->getErrors();
/*
output:

[
    'string' => 'value must be string',
]
*/
```

In the sample above, if `$input` is an integer, then it must be positive.
If `$input` is not an integer, then it must not me empty.


### Comparing Values

#### v::between($min, $max)
#### v::between($min, $max, boolean $inclusive=false)

Validates ranges. Most simple example:

```php
v::int()->between(10, 20)->validate(15); // output: true
```

The type as the first validator in a chain is a good practice,
since between accepts many types:

```php
v::string()->between('a', 'f')->validate('c'); // output: true
```

Also very powerful with dates:

```php
v::date()->between('2009-01-01', '2013-01-01')->validate('2010-01-01'); // output: true
```

Date ranges accept strtotime values:

```php
v::date()->between(new \DateTime('yesterday'), new \DateTime('tomorrow'))->validate('now'); // output: true
```

A third parameter may be passed to validate the passed values inclusive:

```php
v::date()->between(10, 20, true)->validate(20); // output: true
```

Placeholders for this validator includes `{{minValue}}` and `{{maxValue}}`.

See also:

  * [v::min()](#vmin)
  * [v::max()](#vmax)

#### v::equals($value)
#### v::equals($value, boolean $identical=false)
#### v::confirm($value)

Validates if the input is equal some value.

```php
v::equals('alganet')->validate('alganet'); // output: true
```

Identical validation `===` is possible:

```php
v::equals(10)->validate('10'); // output: true
v::equals(10, true)->validate('10'); // output: false
```

Placeholder for this validator includes `{{compareTo}}`.

> `confirm` differs default message.

#### v::max()
#### v::max(boolean $inclusive=false)

Validates if the input doesn't exceed the maximum value.

```php
v::int()->max(15)->validate(20); // output: false
```

Also accepts dates:

```php
v::date()->max(new \DateTime('2012-01-01'))->validate('2010-01-01'); // output: true
```

`true` may be passed as a parameter to indicate that inclusive
values must be used.

Placeholders for this validator includes `{{maxValue}}`.

See also:

  * [v::min()](#vmin)
  * [v::between()](#vbetweenmin-max)

#### v::min()
#### v::min(boolean $inclusive=false)

Validates if the input doesn't exceed the minimum value.

```php
v::int()->min(15)->validate(5); // output: false
```

Also accepts dates:

```php
v::date()->min(new \DateTime('2012-01-01'))->validate('2015-01-01'); // output: true
```

`true` may be passed as a parameter to indicate that inclusive
values must be used.

Placeholder for this validator includes `{{minValue}}`.


### Types

#### v::arr()

Validates if the input is an array or traversable object.

```php
v::arr()->validate(array()); // output: true
v::arr()->validate(new ArrayObject); // output: true
```

#### v::bool()

Validates if the input is a boolean value:

```php
v::bool()->validate(true); // output: true
v::bool()->validate(false); // output: true
```

#### v::closure()

Validates if the input is a callable value:

```php
v::closure()->validate(function(){}); // output: true
```
  
#### v::date()
#### v::date($format)

Validates if input is a date:

```php
v::date()->validate('2009-01-01'); // output: true
```

Also accepts strtotime values:

```php
v::date()->validate('now'); // output: true
```

And DateTime instances:

```php
v::date()->validate(new DateTime); // output: true
```

You can pass a format when validating strings:

```php
v::date('Y-m-d')->validate('01-01-2009'); // output: false
```

Format has no effect when validating DateTime instances.

Placeholders for this validator includes `{{format}}`.

See also:

  * [v::between()](#vbetweenmin-max)
  * [v::min()](#vmin)
  * [v::max()](#vmax)
  
#### v::float()

Validates a floating point number.

```php
v::float()->validate(1.5); // output: true
v::float()->validate('1e5'); // output: true
```  
  
#### v::int()

Validates if the input is an integer.

```php
v::int()->validate('10'); // output: true
v::int()->validate(10); // output: true
```

See also:

  * [v::numeric()](#vnumeric)
  * [v::digit()](#vdigit)

    
#### v::required()

Validates if the given input is not empty or in other words is input mandatory and
required. This function also takes whitespace into account, use `noWhitespace()`
if no spaces or linebreaks and other whitespace anywhere in the input is desired.

```php
v::string()->required()->validate(''); // output: false
```

Null values are empty:

```php
v::required()->required(null); // output: false
```

Numbers:

```php
v::int()->required()->validate(0); // output: false
```

Empty arrays:

```php
v::arr()->required()->validate(array()); // output: false
```

Whitespace:

```php
v::string()->required()->validate('        ');  // output: false
v::string()->required()->validate("\t \n \r");  // output: false
```

See also:

  * [v::noWhitespace()](#noWhitespace)
  * [v::nullValue()](#vnullvalue)

#### v::nullValue()

Validates if the input is null. This rule does not allow empty strings to avoid ambiguity.

```php
v::nullValue()->validate(null); // output: true
```

See also:

  * [v::required()](#vrequired)  
  

#### v::numeric()

Validates on any numeric value.

```php
v::numeric()->validate(-12); // output: true
v::numeric()->validate('135.0'); // output: true
```

See also:

  * [v::int()](#vint)
  * [v::digit()](#vdigit)
    
#### v::object()

Validates if the input is an object.

```php
v::object()->validate(new stdClass); // output: true
```    

#### v::string()

Validates a string.

```php
v::string()->validate('foo'); // output: true
```  
  
  
### CTypes  
  
#### v::alnum()
#### v::alnum(string $additionalChars)

Validates alphanumeric characters from a-Z and 0-9.

```php
v::alnum()->validate('foo 123'); // output: true
```

A parameter for extra characters can be used:

```php
v::alnum('-')->validate('foo - 123'); // output: true
```

This validator allows whitespace, if you want to
remove them add `noWhitespace()` to the chain:

```php
v::alnum()->noWhitespace->validate('foo 123'); // output: false
```

By default empty values are allowed, if you want
to invalidate them, add `required()` to the chain:

```php
v::alnum()->required()->validate(''); // output: false
```

You can restrict case using the `lowercase()` and
`uppercase()` validators:

```php
v::alnum()->uppercase()->validate('aaa'); // output: false
```

Placeholders for this validator includes `{{additionalChars}}` as
the string of extra chars passed as the parameter.

See also:

  * [v::alpha()](#valpha)  - a-Z, empty or whitespace only
  * [v::digit()](#vdigit) - 0-9, empty or whitespace only

#### v::alpha()
#### v::alpha(string $additionalChars)

This is similar to v::alnum(), but it doesn't allow numbers. It also
accepts empty values and whitespace, so use `v::required()` and
`v::noWhitespace()` when appropriate.

See also:

  * [v::alnum()](#valnum)  - a-z0-9, empty or whitespace only
  * [v::digit()](#vdigit) - 0-9, empty or whitespace only
    
#### v::cntrl
#### v::cntrl(string $additionalChars)

This is similar to `v::alnum()`, but only accepts control characters:

```php
v::cntrl()->validate("\n\r\t"); // output: true
```

See also:

  * [v::alnum()](#valnum)     - a-z0-9, empty or whitespace only
  * [v::space()](#vspace)     - empty or whitespace only  
  
#### v::digit()

This is similar to v::alnum(), but it doesn't allow a-Z. It also
accepts empty values and whitespace, so use `v::required()` and
`v::noWhitespace()` when appropriate.

See also:

  * [v::alnum()](#valnum)  - a-z0-9, empty or whitespace only
  * [v::alpha()](#valpha)  - a-Z, empty or whitespace only
    
#### v::graph()
#### v::graph(string $additionalChars)

Validates all characters that are graphically represented.

```php
v::graph()->validate('LKM@#$%4;'); // output: true
```  
  
#### v::space()
#### v::space(string $additionalChars)

Accepts only whitespace:

```php
v::space()->validate('    '); // output: true
```

See also:

  * [v::cntrl()](#vcntrl)  
  

### Numeric

#### v::negative()

Validates if a number is lower than zero

```php
v::numeric()->negative()->validate(-15); // output: true
```

See also:

  * [v::positive()](#vpositive)  
  
  
#### v::odd()

Validates an odd number.

```php
v::int()->odd()->validate(3); // output: true
```

Using `int()` before `odd()` is a best practice.  
  
  
#### v::positive()

Validates if a number is higher than zero

```php
v::numeric()->positive()->validate(-15); // output: false
```

See also:

  * [v::negative()](#vnegative)  
  
  
### String  
  
#### v::contains($value)
#### v::contains($value, boolean $identical=false)

For strings:

```php
v::contains('ipsum')->validate('lorem ipsum'); // output: true
```

For arrays:

```php
v::contains('ipsum')->validate(array('ipsum', 'lorem')); // output: true
```

A second parameter may be passed for identical comparison instead
of equal comparison.

Placeholders for this validator includes `{{containsValue}}`.

See also:

  * [v::startsWith()](#vstartswithvalue)
  * [v::endsWith()](#vendswithvalue)
  * [v::in()](#vinhaystack)  
  
#### v::email()

Validates an email address.

```php
v::email()->validate('alexandre@gaigalas.net'); // output: true
```
  
  
#### v::endsWith($value)
#### v::endsWith($value, boolean $identical=false)

This validator is similar to `v::contains()`, but validates
only if the value is at the end of the input.

For strings:

```php
v::endsWith('ipsum')->validate('lorem ipsum'); // output: true
```

For arrays:

```php
v::endsWith('ipsum')->validate(array('lorem', 'ipsum')); // output: true
```

A second parameter may be passed for identical comparison instead
of equal comparison.

Placeholders for this validator includes `{{endValue}}`.

See also:

  * [v::startsWith()](#vstartswithvalue)
  * [v::contains()](#vcontainsvalue)
  * [v::in()](#vin)  
  
  
#### v::json()

Validates if the given input is a valid JSON.

```php
v::json->validate('{"foo":"bar"}'); // output: true
```  
  
#### v::length($min, $max)
#### v::length($min, null)
#### v::length(null, $max)
#### v::length($min, $max, boolean $inclusive=false)

Validates lengths. Most simple example:

```php
v::string()->length(1, 5)->validate('abc'); // output: true
```

You can also validate only minimum length:

```php
v::string()->length(5, null)->validate('abcdef'); // true
```

Only maximum length:

```php
v::string()->length(null, 5)->validate('abc'); // true
```

The type as the first validator in a chain is a good practice,
since length accepts many types:

```php
v::arr()->length(1, 5)->validate(array('foo', 'bar')); // output: true
```

A third parameter may be passed to validate the passed values inclusive:

```php
v::string()->length(1, 5, true)->validate('a'); // output: true
```

Placeholders for this validator includes `{{minValue}}` and `{{maxValue}}`.

See also:

  * [v::between()](#vbetweenmin-max) - Validates ranges  
  
  
#### v::lowercase()

Validates if string characters are lowercase in the input:

```php
v::string()->lowercase()->validate('xkcd'); // output: true
```

See also:

  * [v::uppercase()](#vuppercase)  
  

#### v::noWhitespace()

Validates if a string contains no whitespace (spaces, tabs and line breaks);

```php
v::noWhitespace()->validate('foo bar');  // output: false
v::noWhitespace()->validate("foo\nbar"); // output: false
```

Like other rules the input is still optional.

```php
v::string()->noWhitespace()->validate('');  // output: true
v::string()->noWhitespace()->validate(' '); // output: false
```

This is most useful when chaining with other validators such as `v::alnum()`    
    
    
#### v::regex($regex)

Evaluates a regex on the input and validates if matches

```php
v::regex('/[a-z]/')->validate('a'); // output: true
```

Placeholders for this validator includes `{{regex}}`
    
    
#### v::startsWith($value)
#### v::startsWith($value, boolean $identical=false)

This validator is similar to `v::contains()`, but validates
only if the value is at the end of the.

For strings:

```php
v::startsWith('lorem')->validate('lorem ipsum'); // output: true
```

For arrays:

```php
v::startsWith('lorem')->validate(array('lorem', 'ipsum')); // output: true
```

`true` may be passed as a parameter to indicate identical comparison
instead of equal.

Placeholders for this validator includes `{{startValue}}`.

See also:

  * [v::endsWith()](#vendswithvalue)
  * [v::contains()](#vcontainsvalue)
  * [v::in()](#vin)
    
    
#### v::uppercase()

Validates if string characters are uppercase in the input:

```php
v::string()->uppercase()->validate('W3C'); // output: true
```

See also:

  * [v::lowercase()](#vlowercase)
  
  
### Files
  
#### v::directory()

Validates directories.

```php
v::directory()->validate(__DIR__); // output: true
v::directory()->validate(__FILE__); // output: false
```

This validator will consider SplFileInfo instances, so you can do something like:

```php
v::directory()->validate(new \SplFileInfo($directory));
```

See also

  * [v::exists)](#vexists)
  * [v::file()](#vfile)  
  
#### v::exists()

Validates files or directories.

```php
v::exists()->validate(__FILE__); // output: true
v::exists()->validate(__DIR__); // output: true
```

This validator will consider SplFileInfo instances, so you can do something like:

```php
v::exists()->validate(new \SplFileInfo($file));
```

See also

  * [v::directory()](#vdirectory)
  * [v::file()](#vfile)  
  

#### v::file()

Validates files.

```php
v::file()->validate(__FILE__); // output: true
v::file()->validate(__DIR__); // output: false
```

This validator will consider SplFileInfo instances, so you can do something like:

```php
v::file()->validate(new \SplFileInfo($file));
```

See also

  * [v::directory()](#vdirectory)
  * [v::exists()](#vexists)  
  
  
#### v::readable()

Validates if the given data is a file exists and is readable.

```php
v::readable()->validate('/path/of/a/readable/file'); // output: true
```
  
#### v::symbolicLink()

Validates if the given data is a path of a valid symbolic link.

```php
v::symbolicLink()->validate('/path/of/valid/symbolic/link'); // output: true
```

#### v::uploaded()

Validates if the given data is a file that was uploaded via HTTP POST.

```php
v::uploaded()->validate('/path/of/an/uploaded/file'); // output: true
```  
  
#### v::writable()

Validates if the given data is a file exists and is writable.

```php
v::writable()->validate('/path/of/a/writable/file'); // output: true
```
  
### Network
  
#### v::domain()

Validates domain names.

```php
v::domain()->validate('google.com');
```

This is a composite validator, it validates several rules
internally:

  * If input is an IP address, it validates.
  * If input contains whitespace, it fails.
  * If input not contains any dot, it fails.
  * If input has less than two parts, it fails.
  * Input must end with a top-level-domain to pass.
  * Each part must be alphanumeric and not start with an hyphen.

Messages for this validator will reflect rules above.

See also:

  * [v::ip()](#vip)  
  
  
#### v::ip()
#### v::ip($options)

Validates IP Addresses. This validator uses the native `filter_var()` PHP function.

```php
v::ip()->validate('192.168.0.1');
```

You can pass a parameter with `filter_var` flags for IP.

```php
v::ip(FILTER_FLAG_NO_PRIV_RANGE)->validate('127.0.0.1'); // output: false
```
  
### Other  
  
#### v::call(mixed $callback)

This is a wildcard validator, it uses a function name, method or closure
to validate something:

```php
v::callback('is_int')->validate(10); // output: true

$callback = function($input) {
                return is_int($input);
            };
v::call($callback)->validate('invalid'); // output: false
```

> Please note that this is a sample, the `v::int()` validator is much better.