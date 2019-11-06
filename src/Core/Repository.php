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
        try {
            $stmt = $this->connection->prepare("SELECT * FROM $this->table");
            $stmt->execute();

            return $stmt->fetchAll();
        }
        catch (ExceptionHandler $exception)
        {
            $exception->handle();
        }

    }

    public function findById(int $id, string $column = 'id')
    {
        $sql = "SELECT * FROM $this->table WHERE $column = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function findBy(array $array = [])
    {

    }

    public function raw(string $sql)
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        }
        catch (ExceptionHandler $exception)
        {
            $exception->handle();
        }
    }

}