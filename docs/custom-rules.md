Custom Rules
==================

Let's create a rule `CSRF`:

```php
use rock\validate\rules\Rule

class CSRF extends Rule
{
    public function __construct($compareTo, $compareIdentical = false, $config = [])
    {
        $this->parentConstruct($config);
        $this->params['compareTo'] = $compareTo;
        $this->params['compareIdentical'] = $compareIdentical;
    }

        /**
         * @inheritdoc
         */
        public function validate($input)
        {
            if ($this->params['compareIdentical']) {
                return $input === $this->params['compareTo'];
            } else {
                return $input == $this->params['compareTo'];
            }
        }    
}
```

Next, create a class of i18n:

```php
use rock\validate\locale\Locale;

class CSRF extends Locale
{
    public function defaultTemplates()
    {
        return [
            self::MODE_DEFAULT => [
                self::STANDARD => 'CSRF-token must be valid',
            ],
            self::MODE_NEGATIVE => [
                self::STANDARD => 'CSRF-token must be invalid',
            ]
        ];
    }
}
```

Profit:

```php
$config = [
    'rules' => [
        'csrf' => [
            'class' => \namespace\to\CSRF::className(),
            'locales' => [
                'en' => \namespace\to\en\CSRF::className(),
            ]
        ],
    ]
];

$sessionCSRF = 'foo';
$requestCSRF = 'bar';
$v = new Validate($config);
$v->csrf($sessionCSRF)->validate($requestCSRF); // output: false

$v->getErrors();
/*
output:

[
    'csrf' => 'CSRF-token must be valid',
]
*/

// or returns first error
 
$v->getFirstErrors();
// output:  CSRF-token must be valid
```