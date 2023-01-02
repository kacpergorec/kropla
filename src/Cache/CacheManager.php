<?php
declare (strict_types=1);

namespace App\Cache;

use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Contracts\Cache\CacheInterface;

class CacheManager
{
    public function __construct(
        private string $enviroment,
        private CacheInterface $cache
    )
    {
    }

    public function get(string $key, callable $callback, int $ttl = 3600)
    {
        if ($this->enviroment === "dev") {
            return $callback();
        }

        return $this->cache->get($key, $callback, $ttl);
    }

}