<?php 

namespace Core;

use PDO;

class Database {
    public $connection;
    public $statement;

    public function __construct($config)
    {
        $dsn = "mysql:" . http_build_query($config, '', ';');
        $this->connection = new PDO($dsn, $user='root', $password='A7mad24*',[
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);        
    }
    public function get() {
        return $this->statement->fetchAll();
    }
    public function query($query, $params = [])
    {
        $this->statement = $this-> connection ->prepare($query);
        $this->statement->execute($params);
        return $this;        
    }
    public function find () {
        return $this->statement->fetch();
    }
    public function findOrFail() {
        $result = $this->find();
        if (! $result) {
            abort();
        }
        return $result;
    }
};