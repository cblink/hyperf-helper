<?php

namespace Cblink\HyperfExt;

use Cblink\HyperfExt\Traits\ApiResponse;
use Hyperf\Resource\Json\JsonResource;
use Psr\Http\Message\ResponseInterface;

abstract class BaseResource extends JsonResource
{
    use ApiResponse;

    /**
     * @return ResponseInterface
     */
    public function toResponse(): ResponseInterface
    {
        return $this->success(is_null($this->resource) ? [] : $this->toArray());
    }

}
