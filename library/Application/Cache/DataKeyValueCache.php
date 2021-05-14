<?php


namespace Application\Cache;


class DataKeyValueCache implements CacheInterface {

    const TYPE_DADATA_GEO_CODER = 'dadata_geo_coder';

    public string $cachePath;

    public function __construct(string $cacheName) {
        $this->cachePath = __DIR__ . '/../../../cache/' . $cacheName;
        if (!file_exists($this->cachePath)) {
            mkdir($this->cachePath, 0700, true);
        }
        $this->cachePath = realpath($this->cachePath) . '/';
    }

    public function cache(string $key, callable $method) {
        if ($this->isRecordExists($key)) {
            echo("cache \n");
            return $this->getRecord($key);
        }
        $value = $method();
        if ($value) {
            $this->setRecord($key, $value);
        }
        return $value;
    }

    private function cacheKey(string $key): string {
        return sha1($key);
    }

    private function recordFilePath(string $key): string {
        return $this->cachePath . $this->cacheKey($key) . '.json';
    }

    private function isRecordExists(string $key): bool {
        return file_exists($this->recordFilePath($key));
    }

    private function getRecord(string $key) {
        $result = null;
        $data   = file_get_contents($this->recordFilePath($key));
        if ($data) {
            $result = json_decode($data, true);
        }
        return $result;
    }

    private function setRecord(string $key, $value): void {
        file_put_contents($this->recordFilePath($key), json_encode($value));
    }
}
