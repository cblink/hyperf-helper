<?php

namespace Cblink\HyperfExt;

use Cblink\HyperfExt\Traits\ApiResponse;
use Hyperf\Resource\Json\ResourceCollection;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Paginator\LengthAwarePaginator;

class BaseCollection extends ResourceCollection
{
    use ApiResponse;

    public function toResponse(): ResponseInterface
    {
        $meta = [];

        if ($this->isPaginatorResource($this->resource)) {
            $meta = [
                'per_page' => $this->resource->perPage(),
                'page' => $this->resource->currentPage(),
            ];
        }

        if ($this->resource instanceof LengthAwarePaginator) {
            $meta['total'] = $this->resource->total();
        }

        return $this->success($this->toArray(), $meta);
    }

}
