<?php


namespace App\Core;


class Repository
{
    private $table;

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

    public function findBy(array $array)
    {

    }

}