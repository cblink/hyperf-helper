<?php

namespace Cblink\HyperfExt;;

use Hyperf\Resource\Json\JsonResource;
use Psr\Http\Message\ResponseInterface;

class BaseResource extends JsonResource
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
