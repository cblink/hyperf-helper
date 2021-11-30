<?php

namespace Cblink\HyperfExt;

use Cblink\Dto\Dto as BaseDto;
use Hyperf\HttpServer\Contract\RequestInterface;

abstract class Dto extends BaseDto
{
    public function __construct($data = null)
    {
        if (!is_array($data)) {
            $data = make(RequestInterface::class)->all();
        }

        parent::__construct($data);
    }
}
