<?php
namespace App\Model\Mapper;

use App\Model\Entity\Participant as EntityParticipant;
use Framework\Model\Mapper\DataMapper;
use PDO;

class Participant extends DataMapper
{
  public function exists(EntityParticipant $entity): bool
  {
    $sql = "SELECT 1 FROM {$this->table} 
            WHERE event_id = :event_id
            AND user_id = :user_id";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":event_id", $entity->getEventId(), PDO::PARAM_INT);
    $statement->bindValue(":user_id", $entity->getUserId(), PDO::PARAM_INT);
    $statement->execute();

    $data = $statement->fetch();

    return empty($data) === false;
  }

  public function store(EntityParticipant $entity)
  {
    $sql = "INSERT INTO {$this->table} 
      (event_id, user_id) VALUES 
      (:event_id, :user_id)";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(':event_id', $entity->getEventId());
    $statement->bindValue(':user_id', $entity->getUserId());
    $statement->execute();

    $entity->setId($this->connection->lastInsertId());
  }
}