<?php

namespace Cblink\HyperfExt;

use Hyperf\Resource\Json\ResourceCollection;
use Psr\Http\Message\ResponseInterface;

class BaseCollection extends ResourceCollection
{
    use ApiResponse;

    public function toResponse(): ResponseInterface
    {
        if ($this->isPaginatorResource($this->resource)) {
            return $this->success($this->toArray(), [
                'per_page' => $this->resource->perPage(),
                'page' => $this->resource->currentPage(),
                'total' => $this->resource->total(),
            ]);
        }

        return $this->success($this->toArray());
    }

}
