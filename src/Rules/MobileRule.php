<?php

namespace Cblink\HyperfExt\Rules;

use Hyperf\Validation\Contract\Rule;

class MobileRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) :bool
    {
        return (bool) preg_match('/^1[3-9]\d{9}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() :array|string
    {
        return '请输入有效的手机号!';
    }
}
