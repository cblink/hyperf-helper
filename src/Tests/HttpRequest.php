<?php

namespace Cblink\HyperfExt\Tests;

trait HttpRequest
{

    /**
     * @var
     */
    protected $headers = [];

    protected $requestData = [];

    /**
     * 原始返回
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return TestResponse
     */
    public function raw(string $method, string $uri,  array $data = [], array $headers = [])
    {
        $header = array_merge($this->headers, $headers);

        $response = $this->client->request($method, $uri, [
            'headers' => $header,
            (in_array($method, ['GET', 'DELETE']) ? 'query':'json')  => $data,
        ]);

        return new TestResponse(strtoupper($method), $uri, $data, $header, $response);
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function get($uri, array $data = [], array $headers = [])
    {
        $header = array_merge($this->headers, $headers);

        $requestData = array_merge($this->requestData, $data);

        $response = $this->client->get($uri, $requestData, $header);

        return new TestResponse('GET', $uri, $requestData, $header, $response);
    }

    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function post($uri, array $data = [], array $headers = [])
    {
        $header = array_merge($this->headers, $headers);

        $requestData = array_merge($this->requestData, $data);

        $response = $this->client->post($uri, $requestData, $header);

        return new TestResponse('POST', $uri, $requestData, $header, $response);
    }


    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function put($uri, array $data = [], array $headers = [])
    {
        $header = array_merge($this->headers, $headers);

        $requestData = array_merge($this->requestData, $data);

        $response = $this->client->put($uri, $requestData, $header);

        return new TestResponse('PUT', $uri, $requestData, $header, $response);
    }


    /**
     * @param $uri
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function delete($uri, array $data = [], array $headers = [])
    {
        $header = array_merge($this->headers, $headers);

        $requestData = array_merge($this->requestData, $data);

        $response = $this->client->delete($uri, $requestData, $header);

        return new TestResponse('DELETE', $uri, $requestData, $header, $response);
    }

}
