<?php

namespace Cblink\HyperfExt\Tools;

use InvalidArgumentException;

class Aes
{
    /**
     * 加密
     *
     * @param array $query
     * @param string $key
     * @param bool $private
     * @return string
     * @throws \Throwable
     */
    public static function encode(array $query, string $key, bool $private = true): string
    {
        // 签名
        $signature = '';
        $dataList = str_split(self::buildQuery($query), 117);

        foreach ($dataList as $item) {

            $private ?
                openssl_private_encrypt($item, $rsaStr, $key) :
                openssl_public_encrypt($item, $rsaStr, $key);

            if (is_null($rsaStr)) {
                throw new InvalidArgumentException('openssl encrypt fail');
            }

            $signature .= $rsaStr;
        }

        //加密后的内容通常含有特殊字符，需要编码转换下
        return base64_encode($signature);
    }

    /**
     * 解密
     *
     * @param string $encrypted
     * @param string $key
     * @param bool $public
     * @return array
     */
    public static function decode(string $encrypted, string $key, bool $public = true): array
    {
        $encrypted = base64_decode($encrypted);

        $result = '';
        $dataList = str_split($encrypted, 128);

        foreach ($dataList as $item) {

            $public ?
                (openssl_public_decrypt($item, $decrypted, $key)) :
                (openssl_private_decrypt($item, $decrypted, $key));

            $result .= $decrypted;
        }

        if (empty($result)) {
            return [];
        }

        parse_str($result, $payload);

        return $payload;
    }

    /**
     * 加签
     *
     * @param array $query
     * @param $key
     * @param bool $private
     * @return string
     */
    public static function sign(array $query, $key, bool $private = true): string
    {
        $data = self::buildQuery($query);

        $privateKey = $private ? openssl_pkey_get_private($key) : openssl_pkey_get_public($key);

        $result = '';
        $dataList = str_split($data, 128);

        foreach ($dataList as $item) {
            (openssl_sign($item, $decrypted, $privateKey));

            $result .= $decrypted;
        }

        return base64_encode($result);
    }

    /**
     * 验签
     *
     * @param array $query
     * @param string $sign
     * @param string $key
     * @param bool $public
     * @return false|int
     */
    public static function verify(array $query, string $sign, string $key, bool $public = true): bool|int
    {
        $key = $public ? openssl_pkey_get_public($key) : openssl_pkey_get_private($key);

        return openssl_verify(self::buildQuery($query), base64_decode($sign), $key);
    }

    /*
     * 查询参数排序 a-z
     * */
    public static function buildQuery(array $query): ?string
    {
        if (!$query) {
            return null;
        }
        //将要 参数 排序
        ksort($query);

        return urldecode(http_build_query($query));
    }
}
