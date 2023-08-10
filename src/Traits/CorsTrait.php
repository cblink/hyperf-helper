<?php

namespace Cblink\HyperfExt\Traits;;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

trait CorsTrait
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function corsResponse($request, $response)
    {
        $response = $response
            ->withHeader('Access-Control-Allow-Origin',
            in_array('*', config('cors.allowed_origins')) ?
                $request->getHeader('Origin') :
                (array_intersect($request->getHeader('Origin'), config('cors.allowed_origins')) ? $request->getHeader('Origin') : '')
            )
            ->withHeader('Vary',
                !$request->getHeader('Vary') ?
                    'Origin' :
                    $response->getHeader('Vary') . ', Origin'
            )->withHeader(
                'Access-Control-Allow-Headers',
                implode(', ',
                    array_map('strtolower',in_array('*', config('cors.allowed_headers')) ?
                        $request->getHeader('Access-Control-Request-Headers') :
                        config('cors.allowed_headers'))
                ))
            ->withHeader(
                'Access-Control-Allow-Methods',
                implode(', ',
                    array_map('strtoupper',in_array('*',  config('cors.allowed_methods')) ?
                        $request->getHeader('Access-Control-Request-Method') :
                        config('cors.allowed_methods')))
            );

        if (config('cors.supports_credentials', false)) {
            $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');
        }

        if ($exposedHeaders = config('cors.exposed_headers', false)) {
            $response = $response->withHeader('Access-Control-Expose-Headers', implode(', ', $exposedHeaders));
        }

        if ($maxAge = config('cors.max_age', false)) {
            $response = $response->withHeader('Access-Control-Max-Age', $maxAge);
        }

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    private function checkCorsOrigin($request)
    {
        if (!$request->getHeader('Access-Control-Allow-Origin')) {
            return false;
        }

        if (in_array('*', config('cors.allowed_origins'))) {
            // allow all '*' flag
            return true;
        }

        $origin = (string) $request->getHeader('Origin');

        if (in_array($origin, config('cors.allowed_origins'))) {
            return true;
        }

        foreach (config('cors.allowed_origins_patterns') as $pattern) {
            if (preg_match($pattern, $origin)) {
                return true;
            }
        }

        return false;
    }
}
