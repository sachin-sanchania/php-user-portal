<?php
require_once __DIR__ . '/../db/Database.php';

class User extends Database {
    protected static string $table = 'users';
}
