<?php
declare(strict_types=1);

if (!function_exists('app')) {
    /**
     * 获取容器实例
     *
     * @return \Psr\Container\ContainerInterface
     */
    function app(): \Psr\Container\ContainerInterface
    {
        return  \Hyperf\Utils\ApplicationContext::getContainer();
    }
}

if (!function_exists('logger')) {
    /**
     * 日志组件
     *
     * @return \Psr\Log\LoggerInterface
     */
    function logger(string $group = 'default')
    {
        return make(\Hyperf\Logger\LoggerFactory::class)
            ->get('default', $group);
    }
}

if (!function_exists('cache')) {
    /**
     * 获取缓存驱动
     *
     * @return mixed|\Psr\SimpleCache\CacheInterface
     */
    function cache()
    {
        return make(\Psr\SimpleCache\CacheInterface::class);
    }
}

if (!function_exists('event')) {
    /**
     * 触发事件
     *
     * @param object $event
     */
    function event(object $event)
    {
        make(\Psr\EventDispatcher\EventDispatcherInterface::class)->dispatch($event);
    }
}

if (! function_exists('real_ip')) {
    /**
     * 获取真实ip.
     *
     * @param null|mixed $request
     * @return mixed
     */
    function real_ip($request = null)
    {
        $request = $request ?? make(\Hyperf\HttpServer\Contract\RequestInterface::class);

        $ip = $request->getHeader('x-forwarded-for');

        if (empty($ip)) {
            $ip = $request->getHeader('x-real-ip');
        }

        if (empty($ip)) {
            $ip = $request->getServerParams()['remote_addr'] ?? '127.0.0.1';
        }

        if (is_array($ip)) {
            $ip = \Hyperf\Utils\Arr::first($ip);
        }

        return \Hyperf\Utils\Arr::first(explode(',', $ip));
    }
}


if (!function_exists('asyncQueue')) {
    /**
     * 投递队列
     *
     * @param \Hyperf\AsyncQueue\Job $job
     * @param int $delay
     * @param string $driver
     */
    function asyncQueue(\Hyperf\AsyncQueue\Job $job, int $delay = 0, string $driver = 'default')
    {
        make(\Hyperf\AsyncQueue\Driver\DriverFactory::class)->get($driver)->push($job, $delay);
    }
}

if (!function_exists('redirect')) {

    /**
     * 页面重定向
     *
     * @param string $url
     * @param int $status
     * @param string $schema
     * @return \Psr\Http\Message\ResponseInterface
     */
    function redirect(string $url, int $status = 302, string $schema = 'http')
    {
        return make(\Hyperf\HttpServer\Contract\ResponseInterface::class)->redirect($url, $status);
    }
}

if (!function_exists('remember')) {

    /**
     * 数据缓存
     *
     * @param $key
     * @param $ttl
     * @param Closure $closure
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    function remember($key, $ttl, Closure $closure)
    {
        if (!empty($value = cache()->get($key))) {
            return $value;
        }

        $value = $closure();

        cache()->set($key, $value, $ttl);

        return $value;
    }
}

if (!function_exists('config_set')) {
    /**
     * 修改配置项
     *
     * @param $key
     * @param $value
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function config_set($key, $value)
    {
        return app()->get(\Hyperf\Contract\ConfigInterface::class)->set($key, $value);
    }
}


if (! function_exists('throw_if')) {
    /**
     * Throw the given exception if the given condition is true.
     *
     * @param  mixed  $condition
     * @param  \Throwable|string  $exception
     * @param  mixed  ...$parameters
     * @return mixed
     *
     * @throws \Throwable
     */
    function throw_if($condition, $exception = 'RuntimeException', ...$parameters)
    {
        if ($condition) {
            if (is_string($exception) && class_exists($exception)) {
                $exception = new $exception(...$parameters);
            }

            throw is_string($exception) ? new RuntimeException($exception) : $exception;
        }

        return $condition;
    }
}

if (! function_exists('throw_unless')) {
    /**
     * Throw the given exception unless the given condition is true.
     *
     * @param  mixed  $condition
     * @param  \Throwable|string  $exception
     * @param  mixed  ...$parameters
     * @return mixed
     *
     * @throws \Throwable
     */
    function throw_unless($condition, $exception = 'RuntimeException', ...$parameters)
    {
        throw_if(! $condition, $exception, ...$parameters);

        return $condition;
    }
}

if (! function_exists('redis')) {
    /**
     * redis用例.
     *
     * @param string $driver
     * @return \Hyperf\Redis\RedisProxy
     */
    function redis(string $driver = 'default')
    {
        return make(\Hyperf\Redis\RedisFactory::class)->get($driver);
    }
}