<?php
namespace Framework\Model\Mapper;

use PDO;

/**
 * These objects are only responsible for the storage. 
 * If you store information in a database, 
 * this would be where the SQL lives. 
 * Or maybe you use an XML file to store data, 
 * and your Data Mappers are parsing from and to XML files.
 */

abstract class DataMapper
{
  protected PDO $connection;
  protected string $table;

  public function __construct(PDO $connection, string $table)
  {
    $this->connection = $connection;
    $this->table = $table;
  }

  // hold connection
}