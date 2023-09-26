<?php
namespace App\Model\Mapper;

use App\Model\Entity\Event as EntityEvent;
use DateTimeImmutable;
use Framework\Model\Mapper\DataMapper;
use PDO;

class Event extends DataMapper
{
  public function exists(EntityEvent $event)
  {
    $sql = "SELECT 1 FROM {$this->table} WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":id", $event->getId(), PDO::PARAM_INT);
    $statement->execute();

    $data = $statement->fetch();

    return empty($data) === false;
  }

  public function create(EntityEvent $event)
  {
    $sql = "INSERT INTO {$this->table} (name, created_on) VALUES (:name, :timestamp)";
    
    $statement = $this->connection->prepare($sql);

    $timestamp = $event->getCreatedOn()->format('Y-m-d H:i:s');

    $statement->bindValue(':name', $event->getName(), PDO::PARAM_STR);
    $statement->bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
    $statement->execute();

    $event->setId($this->connection->lastInsertId());
  }

  public function read(EntityEvent $event)
  {
    $sql = "SELECT * FROM {$this->table} WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":id", $event->getId(), PDO::PARAM_INT);
    $statement->execute();

    $data = $statement->fetch();

    $data['created_on'] = new DateTimeImmutable($data['created_on']);

    if ($data) {
      $this->applyValues($event, $data);
    }
  }
}