<?php

namespace App\Core;

use PDO;

class Connection
{

    private $database;
    private $user;
    private $password;
    private $host;

    /**
     * Connection constructor.
     * @param $database
     * @param $user
     * @param $password
     * @param $host
     */
    public function __construct($database, $user, $password, $host)
    {
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
    }

    public function connect()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=UTF8";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            return new PDO($dsn, $this->user, $this->password, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}