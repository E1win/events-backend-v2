<?php
namespace Framework\Model\Mapper;

use Framework\Model\Mapper\Contract\MapperFactoryInterface;
use PDO;
use RuntimeException;

class MapperFactory implements MapperFactoryInterface
{
  private PDO $connection;
  private array $tables;
  private array $cache = [];

  // tables is assoc array like this:
  // UserMapper => 'users',
  // have separate static constructor here to
  // get table from config

  /**
   * @param PDO $connection
   * @param array $tables A list of table name aliases
   */
  public function __construct(PDO $connection, array $tables = [])
  {
    $this->connection = $connection;

    if (count($tables) == 0) {
      $tables = require ROOT_PATH . '/config/tables.php';
    }

    $this->tables = $tables;
  }

  public function create(string $className)
  {
    if (array_key_exists($className, $this->cache)) {
      return $this->cache[$className];
    }

    if (!class_exists($className)) {
      throw new RuntimeException("Mapper not found. Attempted to load '{$className}.'");
    }

    if (!array_key_exists($className, $this->tables)) {
      throw new RuntimeException("No valid table found for Mapper. Attempted to load '{$className}.'");
    }

    $instance = new $className($this->connection, $this->tables[$className]);
    $this->cache[$className] = $instance;

    return $instance;
  }
}