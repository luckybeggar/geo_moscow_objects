<?php


namespace Application\Cache;


interface CacheInterface {
    /**
     * @return mixed
     */
    public function cache(string $key, callable $method);
}
