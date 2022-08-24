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
     * @param string $idKeyName
     * @param string $childKeyName
     * @param array $sort
     * @return void[]
     */
    public static function transfer(
        array  $data,
        $parentId = 0,
        string $keyName = 'parent_id',
        string $idKeyName = 'id',
        string $childKeyName = 'children',
        array $sort = []
    ): array
    {
        return (new Collection($data))
            ->where($keyName, $parentId)
            ->values()
            ->when(!empty($sort), function (Collection $collect) use($sort){
                return $collect->sortBy($sort);
            })
            ->map(function($item) use ($data, $childKeyName, $keyName, $idKeyName, $sort){
                $item[$childKeyName] = array_values(self::transfer(
                    $data,
                    $item[$idKeyName],
                    $keyName,
                    $idKeyName,
                    $childKeyName,
                    $sort
                ));

                if (empty($item[$childKeyName])) {
                    unset($item[$childKeyName]);
                }

                return $item;
            })
            ->toArray();
    }
}
