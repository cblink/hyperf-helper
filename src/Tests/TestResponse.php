<?php

namespace Cblink\HyperfExt\Tests;

use Cblink\Hyperf\Yapi\Dto;
use Cblink\Hyperf\Yapi\TestResponse as TestBaseResponse;

class TestResponse extends TestBaseResponse
{
    /**
     * @param Dto $dto
     * @return bool
     */
    public function build(Dto $dto) :bool
    {
        $dto->builder($this);

        return true;
    }
}
