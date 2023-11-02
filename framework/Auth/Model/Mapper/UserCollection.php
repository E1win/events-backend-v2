<?php
namespace Framework\Auth\Model\Mapper;

use Framework\Auth\Model\Entity\UserCollection as EntityUserCollection;
use Framework\Model\Mapper\DataMapper;
use PDO;
use PDOStatement;

class UserCollection extends DataMapper
{
  public function fetch(EntityUserCollection $collection)
  {
    $sql = "SELECT * FROM {$this->table} ORDER BY expires_on DESC";

    $statement = $this->connection->prepare($sql);

    $this->populateCollection($collection, $statement);   
  }

  private function populateCollection(EntityUserCollection $collection, PDOStatement $statement)
  {
    $statement->execute();

    foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $parameters) {
      // Don't return sensitive data unless specifically asked for.
      if (!$collection->getShowSensitiveData()) {
        unset($parameters['password']);
        unset($parameters['session_uuid']);
      }

      $collection->addBlueprint($parameters);
    }
  }
}