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
    if ($collection->getUpcoming() !== null) {
      $this->fetchUpcoming($collection);
      return;
    }
    
    $this->fetchUncompleted($collection);
  }

  private function fetchUncompleted(EntityEventCollection $collection)
  {
    $sql = "SELECT * FROM {$this->table} WHERE NOT completed ORDER BY date ASC";

    $statement = $this->connection->prepare($sql);

    $this->populateCollection($collection, $statement);   
  }

  private function fetchUpcoming(EntityEventCollection $collection)
  {
    $limit = $this->formatLimit($collection);
    $sql = "SELECT * FROM {$this->table} WHERE `date` >= DATE(NOW()) {$limit}";

    $statement = $this->connection->prepare($sql);

    $this->populateCollection($collection, $statement);   
  }

  private function fetchAll(EntityEventCollection $collection)
  {
    $sql = "SELECT * FROM {$this->table} ORDER BY date ASC";

    $statement = $this->connection->prepare($sql);

    $this->populateCollection($collection, $statement);   
  }

  private function formatLimit(EntityEventCollection $collection): string
  {
    if ($collection->getAmount() === null) {
      return '';
    } else {
      return 'LIMIT ' . $collection->getAmount();
    }
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