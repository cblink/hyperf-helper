<?php

namespace Cblink\HyperfExt\Rules;

use Hyperf\Validation\Contract\Rule;

class MobileCodeRule implements Rule
{
    /**
     * @param string $attribute
     * @param $value
     * @return bool
     */
    public function passes(string $attribute, $value): bool
    {
        return in_array($value, ['86']);
    }

    public function message() :array|string
    {
        return '暂不支持的区号!';
    }
}
