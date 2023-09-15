<?php
namespace App\Model\Mapper;

use App\Model\Entity\Event as EntityEvent;
use Framework\Model\Mapper\DataMapper;
use PDO;

class Event extends DataMapper
{

  public function store(EntityEvent $event)
  {
    $sql = "INSERT INTO {$this->table} (name, created_on) VALUES (:name, :timestamp)";
    
    $statement = $this->connection->prepare($sql);

    $timestamp = $event->getCreatedOn()->format('Y-m-d H:i:s');

    echo $timestamp;

    $statement->bindValue(':name', $event->getName(), PDO::PARAM_STR);
    $statement->bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
    $statement->execute();

    $event->setId($this->connection->lastInsertId());
  }
}