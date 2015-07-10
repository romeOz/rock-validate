<?php

namespace rock\validate;

use rock\base\ObjectInterface;
use rock\base\ObjectTrait;
use rock\helpers\StringHelper;
use rock\validate\locale\Locale;
use rock\validate\rules\Alnum;
use rock\validate\rules\Alpha;
use rock\validate\rules\Arr;
use rock\validate\rules\Between;
use rock\validate\rules\BoolRule;
use rock\validate\rules\Call;
use rock\validate\rules\Captcha;
use rock\validate\rules\Closure;
use rock\validate\rules\Cntrl;
use rock\validate\rules\Confirm;
use rock\validate\rules\Contains;
use rock\validate\rules\CSRF;
use rock\validate\rules\Date;
use rock\validate\rules\Digit;
use rock\validate\rules\Directory;
use rock\validate\rules\Domain;
use rock\validate\rules\Email;
use rock\validate\rules\EndsWith;
use rock\validate\rules\Equals;
use rock\validate\rules\Exists;
use rock\validate\rules\File;
use rock\validate\rules\FileExtensions;
use rock\validate\rules\FileMimeTypes;
use rock\validate\rules\FileSizeBetween;
use rock\validate\rules\FileSizeMax;
use rock\validate\rules\FileSizeMin;
use rock\validate\rules\FloatRule;
use rock\validate\rules\Graph;
use rock\validate\rules\In;
use rock\validate\rules\IntRule;
use rock\validate\rules\Ip;
use rock\validate\rules\JSON;
use rock\validate\rules\Length;
use rock\validate\rules\Lowercase;
use rock\validate\rules\Max;
use rock\validate\rules\Min;
use rock\validate\rules\Negative;
use rock\validate\rules\Required;
use rock\validate\rules\NoWhitespace;
use rock\validate\rules\NullValue;
use rock\validate\rules\Numeric;
use rock\validate\rules\Object;
use rock\validate\rules\Odd;
use rock\validate\rules\Positive;
use rock\validate\rules\Readable;
use rock\validate\rules\Regex;
use rock\validate\rules\Rule;
use rock\validate\rules\Space;
use rock\validate\rules\StartsWith;
use rock\validate\rules\SymbolicLink;
use rock\validate\rules\Uploaded;
use rock\validate\rules\Uppercase;
use rock\validate\rules\Writable;

/**
 * Class Validate
 *
 * @method static Validate attributes($attributes)
 * @method static Validate notOf(Validate $validate)
 * @method static Validate oneOf(Validate $validate)
 * @method static Validate when(Validate $if, Validate $then, Validate $else = null)
 * @method static Validate locale(string $locale)
 * @method static Validate skipEmpty(BoolRule $skip = true)
 * @method static Validate labelRemainder(string $label = '*')
 *
 * @method static Validate alnum(string $additionalChars = null)
 * @method static Validate alpha(string $additionalChars = null)
 * @method static Validate arr()
 * @method static Validate between(mixed $min = null, mixed $max = null, BoolRule $inclusive = false)
 * @method static Validate bool()
 * @method static Validate captcha(mixed $compareTo)
 * @method static Validate call(callable $call, array $args = null)
 * @method static Validate closure()
 * @method static Validate cntrl()
 * @method static Validate contains(mixed $containsValue, BoolRule $identical = false)
 * @method static Validate confirm(mixed $compareTo)
 * @method static Validate csrf()
 * @method static Validate date(string $format = null)
 * @method static Validate digit(string $additionalChars = null)
 * @method static Validate directory()
 * @method static Validate domain()
 * @method static Validate email()
 * @method static Validate endsWith(mixed $endValue, BoolRule $identical = false)
 * @method static Validate equals(mixed $compareTo, BoolRule $compareIdentical=false)
 * @method static Validate exists()
 * @method static Validate file()
 * @method static Validate fileExtensions($extensions, BoolRule $checkExtensionByMimeType = true)
 * @method static Validate fileMimeTypes($mimeTypes)
 * @method static Validate fileSizeMax(IntRule $maxValue, BoolRule $inclusive = false) *
 * @method static Validate fileSizeMin(IntRule $minValue, BoolRule $inclusive = false)
 * @method static Validate fileSizeBetween(IntRule $min = null, IntRule $max = null, BoolRule $inclusive = false)
 * @method static Validate float()
 * @method static Validate graph(string $additionalChars = null)
 * @method static Validate in(array $haystack, BoolRule $compareIdentical = false)
 * @method static Validate int()
 * @method static Validate ip(array $ipOptions = null)
 * @method static Validate json()
 * @method static Validate length(IntRule $min=null, IntRule $max=null, BoolRule $inclusive = true)
 * @method static Validate lowercase()
 * @method static Validate max(IntRule $maxValue, BoolRule $inclusive = false)
 * @method static Validate min(IntRule $minValue, BoolRule $inclusive = false)
 * @method static Validate negative()
 * @method static Validate required(BoolRule $strict = true)
 * @method static Validate noWhitespace()
 * @method static Validate nullValue()
 * @method static Validate numeric()
 * @method static Validate object()
 * @method static Validate odd()
 * @method static Validate positive()
 * @method static Validate readable()
 * @method static Validate regex($regex)
 * @method static Validate space(string $additionalChars = null)
 * @method static Validate startsWith(mixed $startValue, BoolRule $identical = false)
 * @method static Validate string()
 * @method static Validate symbolicLink()
 * @method static Validate uploaded()
 * @method static Validate uppercase()
 * @method static Validate writable()
 *
 * @package rock\validate
 */
class Validate implements ObjectInterface
{
    use ObjectTrait {
        ObjectTrait::__construct as parentConstruct;
        ObjectTrait::__call as parentCall;
    }

    /**
     * Validate rules.
     * @var array
     */
    public $rules = [];
    /**
     * Change behavior Validate.
     * @var bool
     * @see notOf()
     */
    public $valid = true;
    /**
     * Custom templates.
     * @var array
     */
    public $templates = [];
    /**
     * Custom messages.
     * @var array
     */
    public $messages = [];
    /**
     * Placeholders.
     * @var array
     */
    public $placeholders = [];
    /**
     * Default locale.
     * @var string
     */
    public $locale = 'en';
    /**
     * This is a group validator that acts as an OR operator (if only one condition is valid).
     * @var bool
     */
    public $one = false;
    /**
     * @var boolean whether this validation rule should be skipped if the attribute value
     * is null or an empty string.
     */
    public $skipEmpty = true;
    public $remainder = '*';
    /** @var array  */
    protected $rawRules = [];
    /**
     * Received errors.
     * @var array
     */
    protected $errors = [];

    public function __construct($config = [])
    {
        $this->parentConstruct($config);

        $this->locale = strtolower($this->locale);
        $this->rules = array_merge($this->defaultRules(), $this->rules);
    }

    /**
     * Set templates.
     *
     * ```php
     * $validate->required()
     *          ->email()
     *          ->templates(['required' => Required::NAMED])
     *          ->validate('foo@site.com');
     * ```
     *
     * @param array $templates
     * @return $this
     */
    public function templates(array $templates)
    {
        $this->templates = $templates;
        return $this;
    }

    /**
     * Set placeholders for template.
     *
     * ```php
     * $validate->required()
     *          ->email()
     *          ->placeholders(['name' => 'email'])
     *          ->validate('foo@site.com');
     * ```
     * @param array $placeholders
     * @return $this
     */
    public function placeholders(array $placeholders)
    {
        $this->placeholders = $placeholders;
        return $this;
    }

    /**
     * To set custom messages.
     *
     * ```php
     * $validate->required()
     *          ->email()
     *          ->messages(['required' => 'the value must not be empty'])
     *          ->validate('foo@site.com');
     * ```
     * @param array $messages
     * @return $this
     */
    public function messages(array $messages)
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * Validate value.
     *
     * @param mixed $input
     * @return bool
     * @throws ValidateException
     */
    public function validate($input)
    {
        $this->errors = [];

        foreach($this->rawRules as $rules){

            list($ruleName, $rule) = $rules;

            // notOf or oneOf
            if ($rule instanceof Validate) {
                $rule->validate($input);
                $this->errors = array_merge($this->errors, $rule->getErrors());
                continue;
            }

            if ($rule instanceof When) {
                $rule->valid = $this->valid;
                $rule->validate($input);
                $this->errors = array_merge($this->errors, $rule->getErrors());
                continue;
            }

            if ($rule instanceof Attributes) {
                $config = [
                    'one' => $this->one,
                    'valid' => $this->valid,
                    'remainder' =>  $this->remainder
                ];
                $rule->setProperties($config);
                $rule->validate($input);
                $this->errors = $rule->getErrors();
                break;
            }

            if ($this->skipEmpty && $rule->skipEmpty && $this->isEmpty($input, $rule)) {
                continue;
            }

            if ($rule->validate($input) === $this->valid) {
                continue;
            }
            $this->errors[$ruleName] = $this->error($ruleName, $rule);
            if ($this->one === true) {
                break;
            }
        }
        return empty($this->errors);
    }

    /**
     * Returns all errors.
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Returns first error.
     * @param string|null $attribute
     * @return string|null
     */
    public function getFirstError($attribute = null)
    {
        if (empty($this->errors)) {
            return null;
        }
        if (isset($attribute)) {
            if (isset($this->errors[$attribute])) {
                return current($this->errors[$attribute]);
            }
            return null;
        }
        $error = current($this->errors);
        if (is_array($error)) {
            return current($error);
        }
        return $error;
    }

    /**
     * Returns last error.
     * @param string|null $attribute
     * @return string|null
     */
    public function getLastError($attribute = null)
    {
        if (empty($this->errors)) {
            return null;
        }
        if (isset($attribute)) {
            if (isset($this->errors[$attribute])) {
                return end($this->errors[$attribute]);
            }
            return null;
        }
        $error = end($this->errors);
        if (is_array($error)) {
            return end($error);
        }
        return $error;
    }

    /**
     * Exists rule.
     * @param string $name name of rule.
     * @return bool
     */
    public function existsRule($name)
    {
        return isset($this->rules[$name]);
    }

    /**
     * @return rules\Rule[]
     */
    public function getRawRules()
    {
        return $this->rawRules;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, "{$name}Internal")) {
            return call_user_func_array([$this, "{$name}Internal"], $arguments);
        }

        if (!isset($this->rules[$name])) {
            throw new ValidateException("Unknown rule: {$name}");
        }
        if (!class_exists($this->rules[$name]['class'])) {
            throw new ValidateException(ValidateException::UNKNOWN_CLASS, ['class' => $this->rules[$name]['class']]);
        }

        $rule = $this->getInstanceRule($name, $arguments);
        $this->rawRules[] = [$name, $rule];
        return $this;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::getInstance(), $name], $arguments);
    }

    /**
     * Checks if the given value is empty.
     *
     * A value is considered empty if it is null, an empty array, or the trimmed result is an empty string.
     * Note that this method is different from PHP empty(). It will return false when the value is 0.
     *
     * @param mixed $value the value to be checked
     * @param Rule  $rule
     * @return bool whether the value is empty
     */
    protected function isEmpty($value, Rule $rule)
    {
        if (is_callable($rule->isEmpty)) {
            return call_user_func($rule->isEmpty, $value);
        }

        return $value === null || $value === [] || $value === '';
    }

    protected function attributesInternal($attributes)
    {
        $this->rawRules = [];
        $this->rawRules[] = ['attributes', new Attributes(['attributes' => $attributes, 'one' => $this->one, 'valid' => $this->valid, 'remainder' => $this->remainder])];
        return $this;
    }

    protected function oneOfInternal(Validate $validate)
    {
        $validate->one = true;
        $this->rawRules[] = ['oneOf', $validate];
        return $this;
    }

    protected function notOfInternal(Validate $validate)
    {
        $validate->valid = false;
        $this->rawRules[] = ['notOf', $validate];
        return $this;
    }

    protected function whenInternal(Validate $if, Validate $then, Validate $else = null)
    {
        $this->rawRules[] = ['when', new When(['if' => $if, 'then' => $then, 'else' =>  $else, 'valid' => $this->valid])];
        return $this;
    }

    protected function error($ruleName, Rule $rule)
    {
        if (isset($this->messages[$ruleName])) {
            return $this->replace($this->messages[$ruleName]);
        }
        /** @var Locale $locale */
        $locale = isset($this->rules[$ruleName]['locales'][$this->locale])
            ? $this->rules[$ruleName]['locales'][$this->locale]
            : current($this->rules[$ruleName]['locales']);
        if (!class_exists($locale)) {
            throw new ValidateException(ValidateException::UNKNOWN_CLASS, ['class' => $locale]);
        }
        $locale = new $locale;
        if (!$messages = $locale->defaultTemplates()) {
            throw new ValidateException("Messages `{$locale}` is empty.");
        }
        $this->placeholders = array_merge(call_user_func_array([$locale, 'defaultPlaceholders'], $rule->params), $this->placeholders);
        if (isset($this->templates[$ruleName])) {
            if (!isset($messages[(int)$this->valid][$this->templates[$ruleName]])) {
                throw new ValidateException("Message `{$this->templates[$ruleName]}` is not found.");
            }
            return $this->replace($messages[(int)$this->valid][$this->templates[$ruleName]]);
        }

        return $this->replace($messages[(int)$this->valid][$locale->defaultTemplate]);
    }

    protected function replace($message)
    {
        if (empty($this->placeholders)) {
            return $message;
        }
        return StringHelper::replace($message, $this->placeholders);
    }

    protected function localeInternal($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    protected function SkipEmptyInternal($skip = true)
    {
        $this->skipEmpty = $skip;
        return $this;
    }

    protected function labelRemainderInternal($label = '*')
    {
        $this->remainder = $label;
        return $this;
    }

    /**
     * Returns instance rule.
     * @param string $name name of rule
     * @param array $arguments
     * @return Rule
     */
    protected function getInstanceRule($name, array $arguments)
    {
        $reflect = new \ReflectionClass($this->rules[$name]['class']);
        return $reflect->newInstanceArgs($arguments);
    }

    /**
     * Returns instance.
     *
     * If exists {@see \rock\di\Container} that uses it.
     * @return static
     */
    protected static function getInstance()
    {
        if (class_exists('\rock\di\Container')) {
            return \rock\di\Container::load(static::className());
        }
        return new static();
    }

    protected function defaultRules()
    {
        return [
            'alnum' => [
                'class' => Alnum::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Alnum::className(),
                    'ru' => \rock\validate\locale\ru\Alnum::className(),
                ]
            ],
            'alpha' => [
                'class' => Alpha::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Alpha::className(),
                    'ru' => \rock\validate\locale\ru\Alpha::className(),
                ]
            ],
            'arr' => [
                'class' => Arr::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Arr::className(),
                    'ru' => \rock\validate\locale\ru\Arr::className(),
                ]
            ],
            'between' => [
                'class' => Between::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Between::className(),
                    'ru' => \rock\validate\locale\ru\Between::className(),
                ]
            ],
            'bool' => [
                'class' => BoolRule::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\BoolLocale::className(),
                    'ru' => \rock\validate\locale\ru\BoolLocale::className(),
                ]
            ],
            'call' => [
                'class' => Call::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Call::className(),
                    'ru' => \rock\validate\locale\ru\Call::className(),
                ]
            ],
            'captcha' => [
                'class' => Captcha::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Captcha::className(),
                    'ru' => \rock\validate\locale\ru\Captcha::className(),
                ]
            ],
            'closure' => [
                'class' => Closure::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Closure::className(),
                    'ru' => \rock\validate\locale\ru\Closure::className(),
                ]
            ],
            'cntrl' => [
                'class' => Cntrl::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Cntrl::className(),
                    'ru' => \rock\validate\locale\ru\Cntrl::className(),
                ]
            ],
            'confirm' => [
                'class' => Confirm::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Confirm::className(),
                    'ru' => \rock\validate\locale\ru\Confirm::className(),
                ]
            ],
            'contains' => [
                'class' => Contains::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Contains::className(),
                    'ru' => \rock\validate\locale\ru\Contains::className(),
                ]
            ],
            'csrf' => [
                'class' => CSRF::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\CSRF::className(),
                    'ru' => \rock\validate\locale\ru\CSRF::className(),
                ]
            ],
            'date' => [
                'class' => Date::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Date::className(),
                    'ru' => \rock\validate\locale\ru\Date::className(),
                ]
            ],
            'digit' => [
                'class' => Digit::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Digit::className(),
                    'ru' => \rock\validate\locale\ru\Digit::className(),
                ]
            ],
            'directory' => [
                'class' => Directory::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Directory::className(),
                    'ru' => \rock\validate\locale\ru\Directory::className(),
                ]
            ],
            'domain' => [
                'class' => Domain::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Domain::className(),
                    'ru' => \rock\validate\locale\ru\Domain::className(),
                ]
            ],
            'email' => [
                'class' => Email::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Email::className(),
                    'ru' => \rock\validate\locale\ru\Email::className(),
                ]
            ],
            'endsWith' => [
                'class' => EndsWith::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\EndsWith::className(),
                    'ru' => \rock\validate\locale\ru\EndsWith::className(),
                ]
            ],
            'equals' => [
                'class' => Equals::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Equals::className(),
                    'ru' => \rock\validate\locale\ru\Equals::className(),
                ]
            ],
            'file' => [
                'class' => File::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\File::className(),
                    'ru' => \rock\validate\locale\ru\File::className(),
                ]
            ],
            'fileExists' => [
                'class' => Exists::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Exists::className(),
                    'ru' => \rock\validate\locale\ru\Exists::className(),
                ]
            ],
            'fileExtensions' => [
                'class' => FileExtensions::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\FileExtensions::className(),
                    'ru' => \rock\validate\locale\ru\FileExtensions::className(),
                ]
            ],
            'fileMimeTypes' => [
                'class' => FileMimeTypes::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\FileMimeTypes::className(),
                    'ru' => \rock\validate\locale\ru\FileMimeTypes::className(),
                ]
            ],
            'fileSizeBetween' => [
                'class' => FileSizeBetween::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\FileSizeBetween::className(),
                    'ru' => \rock\validate\locale\ru\FileSizeBetween::className(),
                ]
            ],
            'fileSizeMax' => [
                'class' => FileSizeMax::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\FileSizeMax::className(),
                    'ru' => \rock\validate\locale\ru\FileSizeMax::className(),
                ]
            ],
            'fileSizeMin' => [
                'class' => FileSizeMin::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\FileSizeMin::className(),
                    'ru' => \rock\validate\locale\ru\FileSizeMin::className(),
                ]
            ],
            'float' => [
                'class' => FloatRule::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\FloatLocale::className(),
                    'ru' => \rock\validate\locale\ru\FloatLocale::className(),
                ]
            ],
            'graph' => [
                'class' => Graph::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Graph::className(),
                    'ru' => \rock\validate\locale\ru\Graph::className(),
                ]
            ],
            'in' => [
                'class' => In::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\In::className(),
                    'ru' => \rock\validate\locale\ru\In::className(),
                ]
            ],
            'int' => [
                'class' => IntRule::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\IntLocale::className(),
                    'ru' => \rock\validate\locale\ru\IntLocale::className(),
                ]
            ],
            'ip' => [
                'class' => Ip::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Ip::className(),
                    'ru' => \rock\validate\locale\ru\Ip::className(),
                ]
            ],
            'json' => [
                'class' => JSON::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\JSON::className(),
                    'ru' => \rock\validate\locale\ru\JSON::className(),
                ]
            ],
            'length' => [
                'class' => Length::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Length::className(),
                    'ru' => \rock\validate\locale\ru\Length::className(),
                ]
            ],
            'lowercase' => [
                'class' => Lowercase::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Lowercase::className(),
                    'ru' => \rock\validate\locale\ru\Lowercase::className(),
                ]
            ],
            'max' => [
                'class' => Max::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Max::className(),
                    'ru' => \rock\validate\locale\ru\Max::className(),
                ]
            ],
            'min' => [
                'class' => Min::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Min::className(),
                    'ru' => \rock\validate\locale\ru\Min::className(),
                ]
            ],
            'negative' => [
                'class' => Negative::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Negative::className(),
                    'ru' => \rock\validate\locale\ru\Negative::className(),
                ]
            ],
            'required' => [
                'class' => Required::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Required::className(),
                    'ru' =>\rock\validate\locale\ru\Required::className(),
                ]
            ],
            'noWhitespace' => [
                'class' => NoWhitespace::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\NoWhitespace::className(),
                    'ru' =>\rock\validate\locale\ru\NoWhitespace::className(),
                ]
            ],
            'nullValue' => [
                'class' => NullValue::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\NullValue::className(),
                    'ru' =>\rock\validate\locale\ru\NullValue::className(),
                ]
            ],
            'numeric' => [
                'class' => Numeric::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Numeric::className(),
                    'ru' =>\rock\validate\locale\ru\Numeric::className(),
                ]
            ],
            'object' => [
                'class' => Object::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Object::className(),
                    'ru' =>\rock\validate\locale\ru\Object::className(),
                ]
            ],
            'odd' => [
                'class' => Odd::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Odd::className(),
                    'ru' =>\rock\validate\locale\ru\Odd::className(),
                ]
            ],
            'positive' => [
                'class' => Positive::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Positive::className(),
                    'ru' =>\rock\validate\locale\ru\Positive::className(),
                ]
            ],
            'readable' => [
                'class' => Readable::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Readable::className(),
                    'ru' =>\rock\validate\locale\ru\Readable::className(),
                ]
            ],
            'regex' => [
                'class' => Regex::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Regex::className(),
                    'ru' =>\rock\validate\locale\ru\Regex::className(),
                ]
            ],
            'space' => [
                'class' => Space::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Space::className(),
                    'ru' =>\rock\validate\locale\ru\Space::className(),
                ]
            ],
            'startsWith' => [
                'class' => StartsWith::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\StartsWith::className(),
                    'ru' =>\rock\validate\locale\ru\StartsWith::className(),
                ]
            ],
            'string' => [
                'class' => \rock\validate\rules\StringRule::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\StringLocale::className(),
                    'ru' => \rock\validate\locale\ru\StringLocale::className(),
                ]
            ],
            'symbolicLink' => [
                'class' => SymbolicLink::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\SymbolicLink::className(),
                    'ru' => \rock\validate\locale\ru\SymbolicLink::className(),
                ]
            ],
            'uploaded' => [
                'class' => Uploaded::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Uploaded::className(),
                    'ru' => \rock\validate\locale\ru\Uploaded::className(),
                ]
            ],
            'uppercase' => [
                'class' => Uppercase::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Uppercase::className(),
                    'ru' => \rock\validate\locale\ru\Uppercase::className(),
                ]
            ],
            'writable' => [
                'class' => Writable::className(),
                'locales' => [
                    'en' => \rock\validate\locale\en\Writable::className(),
                    'ru' => \rock\validate\locale\ru\Writable::className(),
                ]
            ],
        ];
    }
}