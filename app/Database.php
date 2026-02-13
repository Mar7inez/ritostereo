<?php

namespace App;

class Database
{
    private static $instance = null;
    private $pdo;
    private $cache;
    
    private function __construct()
    {
        $this->cache = new Cache();
        $this->connect();
    }
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    private function connect()
    {
        $dbPath = __DIR__ . '/../storage/database.sqlite';
        
        try {
            $this->pdo = new \PDO("sqlite:$dbPath");
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            
            // Enable WAL mode for better performance
            $this->pdo->exec("PRAGMA journal_mode=WAL");
            $this->pdo->exec("PRAGMA synchronous=NORMAL");
            $this->pdo->exec("PRAGMA cache_size=10000");
            $this->pdo->exec("PRAGMA temp_store=MEMORY");
            
            $this->createTables();
        } catch (\PDOException $e) {
            logError('Database connection failed: ' . $e->getMessage());
            throw $e;
        }
    }
    
    private function createTables()
    {
        $tables = [
            'shows' => "
                CREATE TABLE IF NOT EXISTS shows (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    fecha TEXT NOT NULL,
                    lugar TEXT NOT NULL,
                    ciudad TEXT NOT NULL,
                    hora TEXT,
                    precio TEXT,
                    entradas TEXT,
                    descripcion TEXT,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            ",
            'gallery' => "
                CREATE TABLE IF NOT EXISTS gallery (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT NOT NULL,
                    image TEXT NOT NULL,
                    type TEXT NOT NULL,
                    caption TEXT,
                    approved BOOLEAN DEFAULT 1,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            ",
            'presskit' => "
                CREATE TABLE IF NOT EXISTS presskit (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    key_name TEXT UNIQUE NOT NULL,
                    value TEXT,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            ",
            'cache' => "
                CREATE TABLE IF NOT EXISTS cache (
                    key TEXT PRIMARY KEY,
                    value TEXT,
                    expires_at DATETIME,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            "
        ];
        
        foreach ($tables as $table => $sql) {
            $this->pdo->exec($sql);
        }
    }
    
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            logError('Query failed: ' . $e->getMessage(), ['sql' => $sql, 'params' => $params]);
            throw $e;
        }
    }
    
    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }
    
    public function fetchOne($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }
    
    public function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        $this->query($sql, $data);
        return $this->pdo->lastInsertId();
    }
    
    public function update($table, $data, $where, $whereParams = [])
    {
        $set = [];
        foreach (array_keys($data) as $key) {
            $set[] = "$key = :$key";
        }
        
        $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE $where";
        
        $params = array_merge($data, $whereParams);
        return $this->query($sql, $params)->rowCount();
    }
    
    public function delete($table, $where, $params = [])
    {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->query($sql, $params)->rowCount();
    }
    
    public function getCachedQuery($key, $sql, $params = [], $ttl = 3600)
    {
        $cacheKey = "db_query_" . md5($sql . serialize($params));
        
        return $this->cache->remember($cacheKey, function() use ($sql, $params) {
            return $this->fetchAll($sql, $params);
        }, $ttl);
    }
    
    public function clearQueryCache()
    {
        $this->query("DELETE FROM cache WHERE key LIKE 'db_query_%'");
    }
    
    public function getShows($limit = null, $offset = 0)
    {
        $sql = "SELECT * FROM shows ORDER BY fecha ASC";
        
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
            return $this->fetchAll($sql, ['limit' => $limit, 'offset' => $offset]);
        }
        
        return $this->getCachedQuery('shows_all', $sql, [], 1800);
    }
    
    public function getGalleryItems($type = null, $limit = null)
    {
        $sql = "SELECT * FROM gallery WHERE approved = 1";
        $params = [];
        
        if ($type) {
            $sql .= " AND type = :type";
            $params['type'] = $type;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
            $params['limit'] = $limit;
        }
        
        return $this->getCachedQuery('gallery_' . ($type ?: 'all'), $sql, $params, 1800);
    }
    
    public function getPresskitValue($key, $default = null)
    {
        $result = $this->fetchOne("SELECT value FROM presskit WHERE key_name = ?", [$key]);
        return $result ? $result['value'] : $default;
    }
    
    public function setPresskitValue($key, $value)
    {
        $sql = "INSERT OR REPLACE INTO presskit (key_name, value, updated_at) VALUES (?, ?, CURRENT_TIMESTAMP)";
        $this->query($sql, [$key, $value]);
    }
}
