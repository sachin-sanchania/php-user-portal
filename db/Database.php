<?php
require_once __DIR__ . '/../config.php';

class Database {
    protected static $pdo;

    protected static function connect() {
        if (!isset(self::$pdo)) {
            try {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("DB Connection Failed: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    protected static function getConnection(): ?PDO
    {
        return static::connect(); // Late binding
    }

    protected static function getTable() {
        return static::$table;
    }

    public static function create(array $data): bool {
        $pdo = static::getConnection();
        $table = static::getTable();

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$table} ($columns) VALUES ($placeholders)";

        return $pdo->prepare($sql)->execute($data);
    }

    public static function find($id): ?array {
        $pdo = static::getConnection();
        $table = static::getTable();

        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function update($id, array $data): bool {
        $pdo = static::getConnection();
        $table = static::getTable();

        $setClause = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $data['id'] = $id;

        return $pdo->prepare("UPDATE {$table} SET $setClause WHERE id = :id")->execute($data);
    }

    public static function delete($id): bool {
        $pdo = static::getConnection();
        $table = static::getTable();

        return $pdo->prepare("DELETE FROM {$table} WHERE id = :id")->execute(['id' => $id]);
    }

    public static function all(): array {
        $pdo = static::getConnection();
        $table = static::getTable();

        return $pdo->query("SELECT * FROM {$table} ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function where($column, $value): array {
        $pdo = static::getConnection();
        $table = static::getTable();

        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
