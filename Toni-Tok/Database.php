<?php

class Database {
    public $connection;

    public function __construct() {

        $root = $_SERVER['DOCUMENT_ROOT'];

        $configuration = require("{$root}/Toni-Tok/controllers/configuration.php");
        
        $dsn = 'mysql:' . http_build_query($configuration['database'], '', ';' );
        
        $this->connection = new PDO($dsn, $username = 'root', $password = 'Tt_1928374655', [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    }

    public function query($query, $params = []) {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement;
    }
}