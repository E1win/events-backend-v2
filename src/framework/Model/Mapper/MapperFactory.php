<?php
namespace Framework\model\Mapper;

use Framework\Model\Mapper\Contract\MapperFactoryInterface;
use PDO;

class MapperFactory implements MapperFactoryInterface
{
  private PDO $connection;
  private string $table;

  public function __construct(PDO $connection, string $table)
  {
    $this->connection = $connection;
    $this->table = $table;
  }

  public function create(string $tableName)
  {

  }
}