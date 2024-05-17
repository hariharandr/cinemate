<?php

class Database
{
    public static $conn = null;

    public static function getConnection()
    {
        if (Database::$conn === null) {
            $servername = get_config('db_server');
            $username = get_config('db_username');
            $password = get_config('db_password');
            $dbname = get_config('db_name');

            // MongoDB URI with authentication database specified
            $uri = "mongodb://$username:$password@$servername/$dbname?authSource=users";

            try {
                $client = new MongoDB\Client($uri);
                Database::$conn = $client->selectDatabase($dbname);
            } catch (MongoDB\Driver\Exception\AuthenticationException $e) {
                die('Authentication failed: ' . $e->getMessage());
            } catch (Exception $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }
        return Database::$conn;
    }
}
