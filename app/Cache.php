<?php

namespace App;

class Cache
{
    private static $cacheDir;
    private static $defaultTtl = 3600; // 1 hora
    
    public static function init()
    {
        self::$cacheDir = __DIR__ . '/../storage/cache';
        
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0755, true);
        }
    }
    
    public static function get($key, $default = null)
    {
        $file = self::getCacheFile($key);
        
        if (!file_exists($file)) {
            return $default;
        }
        
        $data = unserialize(file_get_contents($file));
        
        if ($data['expires'] < time()) {
            self::forget($key);
            return $default;
        }
        
        return $data['value'];
    }
    
    public static function put($key, $value, $ttl = null)
    {
        $ttl = $ttl ?? self::$defaultTtl;
        $file = self::getCacheFile($key);
        
        $data = [
            'value' => $value,
            'expires' => time() + $ttl
        ];
        
        file_put_contents($file, serialize($data), LOCK_EX);
    }
    
    public static function remember($key, $callback, $ttl = null)
    {
        $value = self::get($key);
        
        if ($value === null) {
            $value = $callback();
            self::put($key, $value, $ttl);
        }
        
        return $value;
    }
    
    public static function forget($key)
    {
        $file = self::getCacheFile($key);
        
        if (file_exists($file)) {
            unlink($file);
        }
    }
    
    public static function flush()
    {
        $files = glob(self::$cacheDir . '/*');
        
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
    
    private static function getCacheFile($key)
    {
        return self::$cacheDir . '/' . md5($key) . '.cache';
    }
}
