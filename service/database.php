<?php


class Database {
    private static $connection;
    
    public static function getConnection() {
        if (!self::$connection) {
            // Ganti 'username' dan 'password' sesuai konfigurasi MySQL Anda
            self::$connection = new mysqli('localhost', 'root', '', 'ayosehat');
            if (self::$connection->connect_error) {
                die("Connection failed: " . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }
}