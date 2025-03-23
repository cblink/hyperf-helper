<?php

namespace Cblink\HyperfExt\Traits;

use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Codec\Json;
use Hyperf\Context\Context;
use Psr\Http\Message\ResponseInterface;

trait ApiResponse
{

    /**
     * @param array $data
     * @param array $meta
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function success(array $data = [], array $meta = []): ResponseInterface
    {
        $response = Context::get(ResponseInterface::class);

        $result = [
            'err_code' => 0,
            'data' => $data,
        ];

        if ($meta) {
            $result['meta'] = $meta;
        }

        return $response
            ->withStatus(200)
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream(Json::encode($result)));
    }
}
