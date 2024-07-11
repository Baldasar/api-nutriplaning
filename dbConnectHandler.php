<?php

class dbConnectHandler
{

    static public function getQueryBuilder ()
    {
        $connection = new mysqli("localhost", "lucas", "123456", "nutrimax");
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        return $connection;
    }

}