<?php

namespace rock\validate;

use rock\helpers\String;
use rock\validate\locale\Locale;
use rock\validate\rules\Alnum;
use rock\validate\rules\Alpha;
use rock\validate\rules\Arr;
use rock\validate\rules\Between;
use rock\validate\rules\Bool;
use rock\validate\rules\Call;
use rock\validate\rules\Captcha;
use rock\validate\rules\Closure;
use rock\validate\rules\Cntrl;
use rock\validate\rules\Confirm;
use rock\validate\rules\Contains;
use rock\validate\rules\Date;
use rock\validate\rules\Digit;
use rock\validate\rules\Directory;
use rock\validate\rules\Domain;
use rock\validate\rules\Email;
use rock\validate\rules\EndsWith;
use rock\validate\rules\Equals;
use rock\validate\rules\FileExists;
use rock\validate\rules\File;
use rock\validate\rules\Float;
use rock\validate\rules\Graph;
use rock\validate\rules\In;
use rock\validate\rules\Int;
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
 * @method static Validate allOf(array $attributes)
 * @method static Validate notOf(Validate $validate)
 * @method static Validate oneOf(array $attributes)
 * @method static Validate locale(string $locale)
 *
 * @method static Validate alnum(string $additionalChars = null)
 * @method static Validate alpha(string $additionalChars = null)
 * @method static Validate arr()
 * @method static Validate between(mixed $min = null, mixed $max = null, bool $inclusive = false)
 * @method static Validate bool()
 * @method static Validate captcha(mixed $compareTo)
 * @method static Validate closure()
 * @method static Validate call(mixed $callback)
 * @method static Validate cntrl()
 * @method static Validate contains(mixed $containsValue, bool $identical = false)
 * @method static Validate confirm(mixed $compareTo)
 * @method static Validate date(string $format = null)
 * @method static Validate digit(string $additionalChars = null)
 * @method static Validate directory()
 * @method static Validate domain()
 * @method static Validate email()
 * @method static Validate endsWith(mixed $endValue, bool $identical = false)
 * @method static Validate equals(mixed $compareTo, bool $compareIdentical=false)
 * @method static Validate file()
 * @method static Validate fileExists()
 * @method static Validate float()
 * @method static Validate graph(string $additionalChars = null)
 * @method static Validate in(array $haystack, bool $compareIdentical = false)
 * @method static Validate int()
 * @method static Validate ip(array $ipOptions = null)
 * @method static Validate json()
 * @method static Validate length(int $min=null, int $max=null, bool $inclusive = true)
 * @method static Validate lowercase()
 * @method static Validate max(mixed $maxValue, bool $inclusive = false)
 * @method static Validate min(mixed $minValue, bool $inclusive = false)
 * @method static Validate negative()
 * @method static Validate required()
 * @method static Validate noWhitespace()
 * @method static Validate nullValue()
 * @method static Validate numeric()
 * @method static Validate object()
 * @method static Validate odd()
 * @method static Validate positive()
 * @method static Validate readable()
 * @method static Validate regex($regex)
 * @method static Validate space(string $additionalChars = null)
 * @method static Validate startsWith(mixed $startValue, bool $identical = false)
 * @method static Validate string()
 * @method static Validate symbolicLink()
 * @method static Validate uploaded()
 * @method static Validate uppercase()
 * @method static Validate writable()
 * 
 * @package rock\validate
 */
class Validate implements i18nInterface
{
    use ObjectTrait {
        ObjectTrait::__construct as parentConstruct;
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
    public $locale = self::EN;
    /** @var Rule[]  */
    protected $_rules = [];
    /**
     * Received errors.
     * @var array
     */
    protected $errors = [];

    public function __construct($config = [])
    {
        $this->parentConstruct($config);
        if ($this->locale instanceof \Closure) {
            $this->locale = call_user_func($this->locale, $this);
        }
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
     * @throws Exception
     */
    public function validate($input)
    {
        $this->errors = [];
        foreach($this->_rules as $ruleName => $rule){

            // notOf
            if ($rule instanceof Validate) {
                $rule->validate($input);
                $this->errors = array_merge($this->errors, $rule->getErrors());
                continue;
            }

            if ($rule instanceof AllOf) {
                $rule->valid = $this->valid;
                $rule->validate($input);
                $this->errors = $rule->getErrors();
                break;
            }

            if ($rule instanceof OneOf) {
                $rule->valid = $this->valid;
                $rule->validate($input);
                $this->errors = $rule->getErrors();
                break;
            }

            if ($input === '' && $ruleName !== 'required') {
                continue;
            }

            if ($rule->validate($input) === $this->valid) {
                continue;
            }
            $this->errors[$ruleName] = $this->error($ruleName, $rule);
        }
        return empty($this->errors);
    }

    /**
     * Get all errors.
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get first error.
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
     * Get last error.
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

    public function __call($name, $arguments)
    {
        if ($name === 'notOf' || $name === 'allOf' || $name === 'oneOf' || $name === 'locale') {
            call_user_func_array([$this, "{$name}Internal"], $arguments);
            return $this;
        }

        if (!isset($this->rules[$name])) {
            throw new Exception("Unknown rule: {$name}");
        }
        if (!class_exists($this->rules[$name]['class'])) {
            throw new Exception(Exception::UNKNOWN_CLASS, ['class' => $this->rules[$name]['class']]);
        }
        /** @var Rule $rule */
        $reflect = new \ReflectionClass($this->rules[$name]['class']);
        $rule = $reflect->newInstanceArgs($arguments);
        $this->_rules[$name] = $rule;
        return $this;
    }

    public static function __callStatic($name, $arguments)
    {
        /** @var static $self */
        $self = new static;
        return call_user_func_array([$self, $name], $arguments);
    }

    protected function allOfInternal(array $attributes)
    {
        $this->_rules = [];
        $this->_rules['allOf'] = new AllOf(['attributes' => $attributes, 'valid' => $this->valid]);

        return $this;
    }

    protected function oneOfInternal(array $attributes)
    {
        $this->_rules = [];
        $this->_rules['oneOf'] = new OneOf(['attributes' => $attributes, 'valid' => $this->valid]);
        return $this;
    }

    protected function notOfInternal(Validate $validate)
    {
        $validate->valid = false;
        $this->_rules[] = $validate;
        return $this;
    }

    protected function error($ruleName, Rule $rule)
    {
        if (isset($this->messages[$ruleName])) {
            return $this->replace($this->messages[$ruleName]);
        }
        /** @var Locale $locale */
        $locale = isset($this->rules[$ruleName]['locales'][$this->locale]) ? $this->rules[$ruleName]['locales'][$this->locale] : current($this->rules[$ruleName]['locales']);
        if (!class_exists($locale)) {
            throw new Exception(Exception::UNKNOWN_CLASS, ['class' => $locale]);
        }
        $locale = new $locale;
        if (!$messages = $locale->defaultTemplates()) {
            throw new Exception("Messages `{$locale}` is empty.");
        }
        $this->placeholders = array_merge(call_user_func_array([$locale, 'defaultPlaceholders'], $rule->params), $this->placeholders);
        if (isset($this->templates[$ruleName])) {
            if (!isset($messages[(int)$this->valid][$this->templates[$ruleName]])) {
                throw new Exception("Message `{$this->templates[$ruleName]}` is not found.");
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
        return String::replace($message, $this->placeholders);
    }

    protected function localeInternal($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    protected function defaultRules()
    {
        return [
            'alnum' => [
                'class' => Alnum::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Alnum::className(),
                    self::RU => \rock\validate\locale\ru\Alnum::className(),
                ]
            ],
            'alpha' => [
                'class' => Alpha::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Alpha::className(),
                    self::RU => \rock\validate\locale\ru\Alpha::className(),
                ]
            ],
            'arr' => [
                'class' => Arr::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Arr::className(),
                    self::RU => \rock\validate\locale\ru\Arr::className(),
                ]
            ],
            'between' => [
                'class' => Between::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Between::className(),
                    self::RU => \rock\validate\locale\ru\Between::className(),
                ]
            ],
            'bool' => [
                'class' => Bool::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Bool::className(),
                    self::RU => \rock\validate\locale\ru\Bool::className(),
                ]
            ],
            'call' => [
                'class' => Call::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Call::className(),
                    self::RU => \rock\validate\locale\ru\Call::className(),
                ]
            ],
            'captcha' => [
                'class' => Captcha::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Captcha::className(),
                    self::RU => \rock\validate\locale\ru\Captcha::className(),
                ]
            ],
            'closure' => [
                'class' => Closure::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Closure::className(),
                    self::RU => \rock\validate\locale\ru\Closure::className(),
                ]
            ],
            'cntrl' => [
                'class' => Cntrl::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Cntrl::className(),
                    self::RU => \rock\validate\locale\ru\Cntrl::className(),
                ]
            ],
            'confirm' => [
                'class' => Confirm::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Confirm::className(),
                    self::RU => \rock\validate\locale\ru\Confirm::className(),
                ]
            ],
            'contains' => [
                'class' => Contains::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Contains::className(),
                    self::RU => \rock\validate\locale\ru\Contains::className(),
                ]
            ],
            'date' => [
                'class' => Date::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Date::className(),
                    self::RU => \rock\validate\locale\ru\Date::className(),
                ]
            ],
            'digit' => [
                'class' => Digit::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Digit::className(),
                    self::RU => \rock\validate\locale\ru\Digit::className(),
                ]
            ],
            'directory' => [
                'class' => Directory::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Directory::className(),
                    self::RU => \rock\validate\locale\ru\Directory::className(),
                ]
            ],
            'domain' => [
                'class' => Domain::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Domain::className(),
                    self::RU => \rock\validate\locale\ru\Domain::className(),
                ]
            ],
            'email' => [
                'class' => Email::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Email::className(),
                    self::RU => \rock\validate\locale\ru\Email::className(),
                ]
            ],
            'endsWith' => [
                'class' => EndsWith::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\EndsWith::className(),
                    self::RU => \rock\validate\locale\ru\EndsWith::className(),
                ]
            ],
            'equals' => [
                'class' => Equals::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Equals::className(),
                    self::RU => \rock\validate\locale\ru\Equals::className(),
                ]
            ],
            'file' => [
                'class' => File::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\File::className(),
                    self::RU => \rock\validate\locale\ru\File::className(),
                ]
            ],
            'fileExists' => [
                'class' => FileExists::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\FileExists::className(),
                    self::RU => \rock\validate\locale\ru\FileExists::className(),
                ]
            ],
            'float' => [
                'class' => Float::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Float::className(),
                    self::RU => \rock\validate\locale\ru\Float::className(),
                ]
            ],
            'graph' => [
                'class' => Graph::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Graph::className(),
                    self::RU => \rock\validate\locale\ru\Graph::className(),
                ]
            ],
            'in' => [
                'class' => In::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\In::className(),
                    self::RU => \rock\validate\locale\ru\In::className(),
                ]
            ],
            'int' => [
                'class' => Int::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Int::className(),
                    self::RU => \rock\validate\locale\ru\Int::className(),
                ]
            ],
            'ip' => [
                'class' => Ip::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Ip::className(),
                    self::RU => \rock\validate\locale\ru\Ip::className(),
                ]
            ],
            'json' => [
                'class' => JSON::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\JSON::className(),
                    self::RU => \rock\validate\locale\ru\JSON::className(),
                ]
            ],
            'length' => [
                'class' => Length::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Length::className(),
                    self::RU => \rock\validate\locale\ru\Length::className(),
                ]
            ],
            'lowercase' => [
                'class' => Lowercase::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Lowercase::className(),
                    self::RU => \rock\validate\locale\ru\Lowercase::className(),
                ]
            ],
            'max' => [
                'class' => Max::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Max::className(),
                    self::RU => \rock\validate\locale\ru\Max::className(),
                ]
            ],
            'min' => [
                'class' => Min::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Min::className(),
                    self::RU => \rock\validate\locale\ru\Min::className(),
                ]
            ],
            'negative' => [
                'class' => Negative::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Negative::className(),
                    self::RU => \rock\validate\locale\ru\Negative::className(),
                ]
            ],
            'required' => [
                'class' => Required::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Required::className(),
                    self::RU =>\rock\validate\locale\ru\Required::className(),
                ]
            ],
            'noWhitespace' => [
                'class' => NoWhitespace::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\NoWhitespace::className(),
                    self::RU =>\rock\validate\locale\ru\NoWhitespace::className(),
                ]
            ],
            'nullValue' => [
                'class' => NullValue::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\NullValue::className(),
                    self::RU =>\rock\validate\locale\ru\NullValue::className(),
                ]
            ],
            'numeric' => [
                'class' => Numeric::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Numeric::className(),
                    self::RU =>\rock\validate\locale\ru\Numeric::className(),
                ]
            ],
            'object' => [
                'class' => Object::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Object::className(),
                    self::RU =>\rock\validate\locale\ru\Object::className(),
                ]
            ],
            'odd' => [
                'class' => Odd::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Odd::className(),
                    self::RU =>\rock\validate\locale\ru\Odd::className(),
                ]
            ],
            'positive' => [
                'class' => Positive::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Positive::className(),
                    self::RU =>\rock\validate\locale\ru\Positive::className(),
                ]
            ],
            'readable' => [
                'class' => Readable::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Readable::className(),
                    self::RU =>\rock\validate\locale\ru\Readable::className(),
                ]
            ],
            'regex' => [
                'class' => Regex::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Regex::className(),
                    self::RU =>\rock\validate\locale\ru\Regex::className(),
                ]
            ],
            'space' => [
                'class' => Space::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Space::className(),
                    self::RU =>\rock\validate\locale\ru\Space::className(),
                ]
            ],
            'startsWith' => [
                'class' => StartsWith::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\StartsWith::className(),
                    self::RU =>\rock\validate\locale\ru\StartsWith::className(),
                ]
            ],
            'string' => [
                'class' => \rock\validate\rules\String::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\String::className(),
                    self::RU => \rock\validate\locale\ru\String::className(),
                ]
            ],
            'symbolicLink' => [
                'class' => SymbolicLink::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\SymbolicLink::className(),
                    self::RU => \rock\validate\locale\ru\SymbolicLink::className(),
                ]
            ],
            'uploaded' => [
                'class' => Uploaded::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Uploaded::className(),
                    self::RU => \rock\validate\locale\ru\Uploaded::className(),
                ]
            ],
            'uppercase' => [
                'class' => Uppercase::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Uppercase::className(),
                    self::RU => \rock\validate\locale\ru\Uppercase::className(),
                ]
            ],
            'writable' => [
                'class' => Writable::className(),
                'locales' => [
                    self::EN => \rock\validate\locale\en\Writable::className(),
                    self::RU => \rock\validate\locale\ru\Writable::className(),
                ]
            ],
        ];
    }
}