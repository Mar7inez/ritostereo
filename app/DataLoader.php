<?php

namespace App;

class DataLoader
{
    private static $dataCache = [];
    private static $useDatabase = true;
    
    public static function getPresskitData()
    {
        if (self::$useDatabase) {
            return self::loadFromDatabase('presskit', function() {
                $db = Database::getInstance();
                $data = [];
                
                $rows = $db->fetchAll("SELECT key_name, value FROM presskit");
                foreach ($rows as $row) {
                    $value = $row['value'];
                    // Try to decode JSON, fallback to string
                    $decoded = json_decode($value, true);
                    $data[$row['key_name']] = $decoded !== null ? $decoded : $value;
                }
                
                return $data;
            });
        }
        
        return self::loadFromJson('presskit', function() {
            return json_decode(file_get_contents(__DIR__ . '/../storage/data/presskit.json'), true);
        });
    }
    
    public static function getGalleryData()
    {
        if (self::$useDatabase) {
            return self::loadFromDatabase('gallery', function() {
                $db = Database::getInstance();
                $items = $db->getGalleryItems();
                
                // Transform to old format for compatibility
                $gallery = [
                    'highlights' => [],
                    'timeline' => [],
                    'fan_wall' => [],
                    'filters' => [
                        'cities' => [],
                        'years' => [],
                        'types' => ['photo', 'video', 'backstage', 'fan']
                    ]
                ];
                
                foreach ($items as $item) {
                    switch ($item['type']) {
                        case 'backstage':
                        case 'show':
                            $gallery['highlights'][] = [
                                'id' => 'highlight_' . $item['id'],
                                'title' => $item['title'],
                                'image' => $item['image'],
                                'type' => $item['type']
                            ];
                            break;
                        case 'fan':
                            $gallery['fan_wall'][] = [
                                'id' => 'fan_' . $item['id'],
                                'name' => explode(' - ', $item['title'])[0] ?? 'Anónimo',
                                'city' => explode(' - ', $item['title'])[1] ?? '',
                                'image' => $item['image'],
                                'message' => $item['caption'],
                                'approved' => (bool)$item['approved'],
                                'date' => date('Y-m-d', strtotime($item['created_at']))
                            ];
                            break;
                        default:
                            // Add to timeline or highlights
                            $gallery['highlights'][] = [
                                'id' => 'item_' . $item['id'],
                                'title' => $item['title'],
                                'image' => $item['image'],
                                'type' => $item['type']
                            ];
                    }
                }
                
                return $gallery;
            });
        }
        
        return self::loadFromJson('gallery', function() {
            return json_decode(file_get_contents(__DIR__ . '/../storage/data/gallery.json'), true);
        });
    }
    
    public static function getShowsData()
    {
        if (self::$useDatabase) {
            return self::loadFromDatabase('shows', function() {
                $db = Database::getInstance();
                return $db->getShows();
            });
        }
        
        return self::loadFromJson('shows', function() {
            $data = json_decode(file_get_contents(__DIR__ . '/../storage/data/shows.json'), true);
            $shows = $data['shows'] ?? [];
            
            // Ordenar por fecha
            usort($shows, function($a, $b) {
                return strcmp($a['fecha'], $b['fecha']);
            });
            
            return $shows;
        });
    }
    
    public static function getAllData()
    {
        return [
            'presskit' => self::getPresskitData(),
            'gallery' => self::getGalleryData(),
            'shows' => self::getShowsData()
        ];
    }
    
    private static function loadFromDatabase($key, $loader)
    {
        if (!isset(self::$dataCache[$key])) {
            self::$dataCache[$key] = Cache::remember("data_$key", $loader, 1800); // 30 min cache
        }
        
        return self::$dataCache[$key];
    }
    
    private static function loadFromJson($key, $loader)
    {
        if (!isset(self::$dataCache[$key])) {
            self::$dataCache[$key] = Cache::remember("data_$key", $loader, 1800); // 30 min cache
        }
        
        return self::$dataCache[$key];
    }
    
    public static function clearCache()
    {
        self::$dataCache = [];
        Cache::forget('data_presskit');
        Cache::forget('data_gallery');
        Cache::forget('data_shows');
    }
    
    public static function setUseDatabase($useDatabase)
    {
        self::$useDatabase = $useDatabase;
    }
}
