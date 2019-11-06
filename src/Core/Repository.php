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

    public function findBy(array $clauses = [])
    {
        try {
            $sql = "SELECT * FROM $this->table";
            $iterator = 0;
            $bindParams = [];
            foreach ($clauses as $key => $value)
            {
                if ($iterator === 0)
                {
                    $sql.=" WHERE $key = :$key";
                    $iterator++;
                    $bindParams[$key] = $value;
                    continue;
                }
                $sql.=" AND $key = :$key";
                $bindParams[$key] = $value;
            }
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($bindParams);

            return $stmt->fetch();
        }
        catch (ExceptionHandler $exception)
        {
            $exception->handle();
        }
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