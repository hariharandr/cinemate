<?php

class Database
{
    public static $conn = null;

    public static function getConnection()
    {
        if (Database::$conn == null) {
            $servername = get_config('db_server');
            $username = get_config('db_username');
            $password = get_config('db_password');
            $dbname = get_config('db_name');

            // MongoDB connection string
            $uri = "mongodb://$username:$password@$servername/$dbname";

            // Create connection
            try {
                $client = new MongoDB\Client($uri);
                Database::$conn = $client->selectDatabase($dbname);
            } catch (Exception $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return Database::$conn;
    }
}
