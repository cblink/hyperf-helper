<?php

namespace Cblink\HyperfExt;

use Cblink\HyperfExt\Triats\ApiResponse;
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
        return $this->success($this->toArray());
    }

}
