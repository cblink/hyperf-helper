<?php

namespace Cblink\HyperfExt\Rules;

use Hyperf\Validation\Contract\Rule;

class IdCardRule implements Rule
{
    /**
     * @param string $attribute
     * @param $value
     * @return bool
     */
    public function passes(string $attribute, $value): bool
    {
        $regx = '/^[1-9]\d{5}(19|20)\d{2}(0[1-9]|10|11|12)([0-2][0-9]|30|31)\d{3}[0-9Xx]$/';

        if (!preg_match($regx, $value)) {
            return false;
        }

        return substr($value, -1) == $this->iso7064(substr($value, 0, 17));
    }

    public function message()
    {
        return '请输入有效的身份证号码!';
    }

    /**
     * @param $vString
     * @return array|string|string[]
     */
    function iso7064($vString)
    {
        // ISO 7064:1983.MOD 11-2
        $wi = [1, 2, 4, 8, 5, 10, 9, 7, 3, 6];
        $hash_map = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
        $i_size = strlen($vString);
        $bModify = substr($vString, -1) == '?';
        $i_size1 = $bModify ? $i_size : $i_size + 1;
        $sigma = 0;
        for ($i = 1; $i <= $i_size; $i++) {
            $i1 = $vString[$i - 1] * 1;
            $w1 = $wi[($i_size1 - $i) % 10];
            $sigma += ($i1 * $w1) % 11;
        }

        return $bModify ?
            str_replace('?', $hash_map[($sigma % 11)], $vString) :
            $hash_map[($sigma % 11)];
    }
}