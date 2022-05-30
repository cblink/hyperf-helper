<?php

namespace Cblink\HyperfExt\Tools;

use Hyperf\Utils\Collection;

class Tree
{
    /**
     * 无限极递归
     *
     * @param array $data
     * @param int|string $parentId
     * @param string $keyName
     * @param string $childKeyName
     * @param string $idKeyName
     * @return void[]
     */
    public static function transfer(
        array  $data,
        $parentId = 0,
        string $keyName = 'parent_id',
        string $idKeyName = 'id',
        string $childKeyName = 'children'
    ): array
    {
        $result = (new Collection($data))->where($keyName, $parentId)->all();

        return array_map(function ($item) use ($data, $childKeyName, $keyName, $idKeyName) {
            $item[$childKeyName] = array_values(self::transfer(
                $data,
                $item[$idKeyName],
                $keyName,
                $idKeyName,
                $childKeyName)
            );

            if (empty($item[$childKeyName])) {
                unset($item[$childKeyName]);
            }

            return $item;
        }, $result);
    }
}
