<?php
namespace App\Model\Mapper;

use App\Model\Entity\Participant as EntityParticipant;
use App\Model\Entity\ParticipantCollection as EntityParticipantCollection;
use Framework\Model\Mapper\DataMapper;
use PDO;
use PDOStatement;

class ParticipantCollection extends DataMapper
{
  public function fetch(EntityParticipantCollection $collection)
  {
    if ($collection->getEventId() !== null) {
      $this->fetchByEvent($collection);
    } else if ($collection->getUserId() !== null) {
      $this->fetchByUser($collection);
    } else {
      $sql = "SELECT * FROM {$this->table}";
  
      $statement = $this->connection->prepare($sql);
  
      $this->populateCollection($collection, $statement);   
    }
  }

  private function fetchByEvent(EntityParticipantCollection $collection)
  {
    $sql = "SELECT * FROM {$this->table}
      WHERE event_id = :event_id";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue('event_id', $collection->getEventId());

    $this->populateCollection($collection, $statement);
  }

  private function fetchByUser(EntityParticipantCollection $collection)
  {
    
  }

  private function populateCollection(EntityParticipantCollection $collection, PDOStatement $statement)
  {
    $statement->execute();

    foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $parameters) {
      $collection->addBlueprint($parameters);
    }
  }
}