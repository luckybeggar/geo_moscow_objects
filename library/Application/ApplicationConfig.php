<?php
namespace Application;

use Exception;

class ApplicationConfig {
    private const CONFIG_FILE_PATH = 'config/config.php';
    public static function getConfig():array {
        $filePath = __DIR__ . '/../../' . self::CONFIG_FILE_PATH;
        if (!file_exists($filePath)) {
            throw new Exception('No config file '. $filePath);
        }
        $config = include $filePath;
        return $config;
    }
}
