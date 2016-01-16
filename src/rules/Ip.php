<?php

namespace rock\validate\rules;


use rock\validate\ValidateException;

class Ip extends Rule
{
    public function __construct($range = null, $options = null, $config = [])
    {
        parent::__construct($config);
        $this->params = [
            'range' => $this->parseRange($range),
            'options' => $options
        ];
    }

    /**
     * @inheritdoc
     */
    public function validate($input)
    {
        return $this->verifyAddress($input) && $this->verifyNetwork($input);
    }

    protected function parseRange($input)
    {
        if ($input === null || $input == '*' || $input == '*.*.*.*'
            || $input == '0.0.0.0-255.255.255.255') {
            return null;
        }
        if ($input == '*:*:*:*:*:*' || $input == '0:0:0:0:0:0-ffff:ffff:ffff:ffff:ffff:ffff') {
            return null;
        }
        $range = ['min' => null, 'max' => null, 'mask' => null];

        if (strpos($input, '-') !== false) {
            list($range['min'], $range['max']) = explode('-', $input);
        } elseif (strpos($input, '*') !== false) {
            $this->parseRangeUsingWildcards($input, $range);
        } elseif (strpos($input, '/') !== false) {
            $this->parseRangeUsingCidr($input, $range);
        } else {
            throw new ValidateException('Invalid network range');
        }

        if (!$this->verifyAddress($range['min'])) {
            throw new ValidateException('Invalid network range');
        }

        if (isset($range['max']) && !$this->verifyAddress($range['max'])) {
            throw new ValidateException('Invalid network range.');
        }
        return $range;
    }

    protected function fillAddress($input, $char = '*')
    {
        if (strpos($input, ':') !== false) {
            while (substr_count($input, ':') < 7) {
                $input .= ':' . $char;
            }
            return $input;
        }
        while (substr_count($input, '.') < 3) {
            $input .= '.' . $char;
        }
        return $input;
    }

    protected function parseRangeUsingWildcards($input, &$range)
    {
        $input = $this->fillAddress($input);

        if (strpos($input, ':') !== false) {
            $range['min'] = strtr($input, '*', '0000');
            $range['max'] = str_replace('*', 'ffff', $input);
            return;
        }
        $range['min'] = strtr($input, '*', '0');
        $range['max'] = str_replace('*', '255', $input);
    }

    protected function parseRangeUsingCidr($input, &$range)
    {
        $input = explode('/', $input);

        if (strpos($input[0], ':') !== false) {
            $range['min'] = $input[0];
            if (strpos($input[1], ':') !== false) {
                $range['mask'] =  strlen(str_replace('0', '', $this->IPv6toBit(inet_pton($input[1]))));
                return;
            }
            $range['mask'] = $input[1];
            return;
        }
        $range['min'] = $this->fillAddress($input[0], '0');
        if (strpos($input[1], '.') !== false && $this->verifyAddress($input[1])) {
            $range['mask'] = sprintf('%032b', ip2long($input[1]));

            return ;
        }

        if ($input[1] < 8 || $input[1] > 30) {
            throw new ValidateException('Invalid network mask.');
        }

        $range['mask'] = sprintf('%032b', ip2long(long2ip(~(pow(2, (32 - $input[1])) - 1))));
    }

    protected function verifyAddress($address)
    {
        return (boolean) filter_var($address, FILTER_VALIDATE_IP, isset($this->params['options']) ? ['flags' => $this->params['options']] : null);
    }

    protected function verifyNetwork($input)
    {
        if ($this->params['range'] === null) {
            return true;
        }

        if (isset($this->params['range']['mask'])) {
            return $this->belongsToSubnet($input);
        }

        $min = $this->ip2long($this->params['range']['min']);
        $max = $this->ip2long($this->params['range']['max']);
        $input = $this->ip2long($input);
        return $input >= $min && $input <= $max;
    }

    protected function belongsToSubnet($input)
    {
        $range = $this->params['range'];
        if ($this->isIPv6($input)) {
            $input = $this->IPv6toBit(inet_pton($input));
            $range['min'] = $this->IPv6toBit(inet_pton($range['min']));

            return substr($input, 0, $range['mask']) === substr($range['min'], 0, $range['mask']);
        }

        $min = sprintf('%032b', ip2long($range['min']));
        $input = sprintf('%032b', ip2long($input));

        return ($input & $range['mask']) === ($min & $range['mask']);
    }

    protected function ip2long($ip)
    {
        $long = -1;
        if ($this->isIPv6($ip)) {
            if (!function_exists('bcadd')) {
                throw new \RuntimeException('BCMATH extension not installed.');
            }
            $ip_n = inet_pton($ip);
            $bin = '';
            for ($bit = strlen($ip_n) - 1; $bit >= 0; $bit--) {
                $bin = sprintf('%08b', ord($ip_n[$bit])) . $bin;
            }
            $dec = '0';
            for ($i = 0; $i < strlen($bin); $i++) {
                $dec = bcmul($dec, '2', 0);
                $dec = bcadd($dec, $bin[$i], 0);
            }
            $long = $dec;
        } elseif ($this->isIPv4($ip)) {
            $long = ip2long($ip);
        }
        return $long;
    }

    /**
     * Gets IP string representation from IP long
     *
     * @param string $dec IPv4 or IPv6 long
     * @param bool $ipv6
     * @return string If IP is valid returns IP string representation, otherwise ''.
     */
    protected function long2ip($dec, $ipv6 = false)
    {
        if ($ipv6) {
            if (!function_exists('bcadd')) {
                throw new \RuntimeException('BCMATH extension not installed.');
            }
            $bin = '';
            do {
                $bin = bcmod($dec, '2') . $bin;
                $dec = bcdiv($dec, '2', 0);
            } while (bccomp($dec, '0'));
            $bin = str_pad($bin, 128, '0', STR_PAD_LEFT);
            $ip = [];
            for ($bit = 0; $bit <= 7; $bit++) {
                $bin_part = substr($bin, $bit * 16, 16);
                $ip[] = dechex(bindec($bin_part));
            }
            $ip = implode(':', $ip);
            $ipstr = inet_ntop(inet_pton($ip));
        } else {
            $ipstr = long2ip($dec);
        }
        return $ipstr;
    }

    protected function IPv6toBit($ip)
    {
        $result = '';
        $ip = str_split(unpack('A16', $ip)[1]);
        foreach ($ip as $char) {
            $result .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }
        return $result;
    }

    protected function isIPv6($ip)
    {
        return (bool)filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    protected function isIPv4($ip)
    {
        return (bool)filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
} 