<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Cblink\HyperfExt\Tests;

use Hyperf\Testing\Client;
use PHPUnit\Framework\TestCase;

/**
 *
 */
abstract class HttpTestCase extends TestCase
{
    use HttpRequest, HttpAssert;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var
     */
    protected $headers = [];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = make(Client::class);
    }

    /**
     * @param TestResponse|array $data
     * @param array $struct
     * @param bool $meta
     * @throws \Throwable
     */
    public function assertApiSuccess($data = [], array $struct = [], bool $meta = false)
    {
        if ($data instanceof TestResponse) {
            $data = $data->response();
        }

        $this->assertArrayHasKey('err_code', $data);
        $this->assertEquals($data['err_code'], 0);

        $structData = [
            'data' => $struct
        ];

        if ($meta) {
            $structData['meta'] = [
                'per_page',
                'page',
                'total',
            ];
        }

        // 如果需要验证结构体，并且不是列表数据的结构体
        if (!empty($struct)&& !empty($data)) {
            $this->assertJsonStructure($structData, $data);
        }
    }

}
