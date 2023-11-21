<?php
namespace App\Model\Mapper;

use App\Model\Entity\Participant as EntityParticipant;
use Framework\Model\Mapper\DataMapper;
use PDO;

class Participant extends DataMapper
{

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