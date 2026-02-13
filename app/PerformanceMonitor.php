<?php

namespace App;

class PerformanceMonitor
{
    private static $startTime;
    private static $checkpoints = [];
    private static $enabled = false;
    
    public static function init()
    {
        self::$startTime = microtime(true);
        self::$enabled = config('ENABLE_PERFORMANCE_MONITORING', false);
    }
    
    public static function checkpoint($name)
    {
        if (!self::$enabled) return;
        
        $currentTime = microtime(true);
        $elapsed = ($currentTime - self::$startTime) * 1000;
        
        self::$checkpoints[$name] = [
            'time' => $elapsed,
            'memory' => memory_get_usage(true),
            'peak_memory' => memory_get_peak_usage(true)
        ];
    }
    
    public static function getMetrics()
    {
        $endTime = microtime(true);
        $totalTime = ($endTime - self::$startTime) * 1000;
        
        $metrics = [
            'total_execution_time' => round($totalTime, 2) . 'ms',
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . 'MB',
            'peak_memory' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . 'MB',
            'checkpoints' => self::$checkpoints
        ];
        
        return $metrics;
    }
    
    public static function logSlowQueries($threshold = 1000)
    {
        if (!self::$enabled) return;
        
        $slowQueries = array_filter(self::$checkpoints, function($checkpoint) use ($threshold) {
            return $checkpoint['time'] > $threshold;
        });
        
        if (!empty($slowQueries)) {
            logError('Slow queries detected', $slowQueries);
        }
    }
    
    public static function getRecommendations()
    {
        $recommendations = [];
        $metrics = self::getMetrics();
        
        // Check execution time
        if (floatval($metrics['total_execution_time']) > 1000) {
            $recommendations[] = 'Consider enabling more aggressive caching';
        }
        
        // Check memory usage
        $memoryMB = floatval($metrics['memory_usage']);
        if ($memoryMB > 64) {
            $recommendations[] = 'High memory usage detected - consider optimizing data loading';
        }
        
        // Check for slow checkpoints
        foreach (self::$checkpoints as $name => $checkpoint) {
            if ($checkpoint['time'] > 500) {
                $recommendations[] = "Slow operation detected: $name ({$checkpoint['time']}ms)";
            }
        }
        
        return $recommendations;
    }
}
