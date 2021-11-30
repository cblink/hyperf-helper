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

if (!function_exists('auth')) {
    /**
     * 认证组件
     *
     * @param string|null $guard
     * @return \HyperfExt\Auth\Contracts\GuardInterface|\HyperfExt\Auth\Contracts\StatefulGuardInterface|\HyperfExt\Auth\Contracts\StatelessGuardInterface
     */
    function auth(string $guard = null) {

        if (is_null($guard)) $guard = config('auth.default.guard');

        return make(\HyperfExt\Auth\Contracts\AuthManagerInterface::class)
            ->guard($guard);
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
        if (cache()->has($key)) {
            return cache()->get($key);
        }

        $value = $closure();

        cache()->set($key, $ttl, $value);

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
    function config_set($key, $value): mixed
    {
        return app()->get(\Hyperf\Contract\ConfigInterface::class)->set($key, $value);
    }
}
