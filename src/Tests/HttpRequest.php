<?php

namespace Cblink\HyperfExt\Tests;

trait HttpRequest
{

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
        $response = $this->client->request($method, $uri, [
            'headers' => $headers,
            (in_array($method, ['GET', 'DELETE']) ? 'query':'json')  => $data,
        ]);

        return new TestResponse(strtoupper($method), $uri, $data, $headers, $response);
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

        $response = $this->client->get($uri, $data, $header);

        return new TestResponse('GET', $uri, $data, $header, $response);
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

        $response = $this->client->post($uri, $data, $header);

        return new TestResponse('POST', $uri, $data, $header, $response);
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

        $response = $this->client->put($uri, $data, $header);

        return new TestResponse('PUT', $uri, $data, $header, $response);
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

        $response = $this->client->delete($uri, $data, $header);

        return new TestResponse('DELETE', $uri, $data, $header, $response);
    }

}
