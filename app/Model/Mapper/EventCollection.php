<?php
namespace App\Model\Mapper;

use App\Model\Entity\EventCollection as EntityEventCollection;
use Framework\Model\Mapper\DataMapper;
use PDO;
use PDOStatement;

class EventCollection extends DataMapper
{
  public function fetch(EntityEventCollection $collection)
  {
    $sql = "SELECT * FROM {$this->table}";

    $statement = $this->connection->prepare($sql);

    $this->populateCollection($collection, $statement);   
  }

  private function populateCollection(EntityEventCollection $collection, PDOStatement $statement)
  {
    $statement->execute();

    foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $parameters) {
      $parameters["date"] = new \DateTimeImmutable($parameters['date']);
      $collection->addBlueprint($parameters);
    }
  }
}