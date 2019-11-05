<?php


namespace App\Core;


class Repository
{
    private $table;
    /**
     * @var \PDO
     */
    private $connection;

    public function __construct(Container $container)
    {
        $this->connection = $container->get('connection');
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function all()
    {

    }

    public function findById($id)
    {

    }

    public function findBy(array $array = [])
    {

    }

}