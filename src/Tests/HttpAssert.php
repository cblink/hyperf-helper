<?php

namespace Cblink\HyperfExt\Tests;

use PHPUnit\Framework\Assert as PHPUnit;

trait HttpAssert
{
    /**
     * Validate and return the decoded response JSON.
     *
     * @param  string|null  $key
     * @return mixed
     *
     * @throws \Throwable
     */
    public function decodeResponseJson($decodedResponse, $key = null)
    {
        if (is_null($decodedResponse) || $decodedResponse === false) {
            PHPUnit::fail('Invalid JSON was returned from the route.');
        }

        return data_get($decodedResponse, $key);
    }

    /**
     * Get the assertion message for assertJson.
     *
     * @param array $response
     * @param array $data
     * @return string
     * @throws \Throwable
     */
    protected function assertJsonMessage(array $response, array $data)
    {
        $expected = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $actual = json_encode($this->decodeResponseJson($response), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        return 'Unable to find JSON: '.PHP_EOL.PHP_EOL.
            "[{$expected}]".PHP_EOL.PHP_EOL.
            'within response JSON:'.PHP_EOL.PHP_EOL.
            "[{$actual}].".PHP_EOL.PHP_EOL;
    }


    /**
     * Assert that the response has a given JSON structure.
     *
     * @param array|null $structure
     * @param null $responseData
     * @return $this
     * @throws \Throwable
     */
    public function assertJsonStructure(array $structure = null, $responseData = null)
    {
        foreach ($structure as $key => $value) {
            if (is_array($value) && $key === '*') {
                PHPUnit::assertIsArray($responseData);

                foreach ($responseData as $responseDataItem) {
                    $this->assertJsonStructure($structure['*'], $responseDataItem);
                }
            } elseif (is_array($value)) {
                PHPUnit::assertArrayHasKey($key, $responseData);

                $this->assertJsonStructure($structure[$key], $responseData[$key]);
            } else {
                PHPUnit::assertArrayHasKey($value, $responseData);
            }
        }

        return $this;
    }

}
