<?php

class DB {
    
    public static function getConnection() {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        
        $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    }
    
}
