<?php
namespace App\Model\Mapper;

use App\Model\Entity\Event as EntityEvent;
use DateTimeImmutable;
use Framework\Model\Mapper\DataMapper;
use PDO;

class Event extends DataMapper
{
  public function exists(EntityEvent $entity)
  {
    $sql = "SELECT 1 FROM {$this->table} WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":id", $entity->getId(), PDO::PARAM_INT);
    $statement->execute();

    $data = $statement->fetch();

    return empty($data) === false;
  }

  public function fetch(EntityEvent $entity)
  {
    $sql = "SELECT * FROM {$this->table} WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":id", $entity->getId());
    $statement->execute();

    $data = $statement->fetch();

    $data['date'] = new DateTimeImmutable($data['date']);

    if ($data) {
      $this->applyValues($entity, $data);
    }
  }

  public function store(EntityEvent $entity)
  {
    if ($entity->getId() === null) {
      $this->createEvent($entity);
      return;
    }

    $this->updateEvent($entity);
  }

  public function delete(EntityEvent $entity)
  {
    $sql = "DELETE FROM {$this->table} WHERE id = :id";

    $statement = $this->connection->prepare($sql);
    $statement->bindValue(':id', $entity->getId());

    $statement->execute();
  }

  private function createEvent(EntityEvent $entity) 
  {
    $sql = "INSERT INTO {$this->table} 
      (name, description, date, start_time, end_time, location, image_id) VALUES 
      (:name, :description, :date, :start_time, :end_time, :location, :image_id)";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(':name', $entity->getName());
    $statement->bindValue(':description', $entity->getDescription());
    $statement->bindValue(':date', $entity->getDate()->format('Y-m-d'));
    $statement->bindValue(':start_time', $entity->getStartTime());
    $statement->bindValue(':end_time', $entity->getEndTime());
    $statement->bindValue(':location', $entity->getLocation());
    $statement->bindValue(':image_id', $entity->getImageId());
    $statement->execute();

    $entity->setId($this->connection->lastInsertId());
  }

  private function updateEvent(EntityEvent $entity) 
  {
    $sql = "UPDATE {$this->table}
            SET name = :name,
                description = :description,
                date = :date, 
                start_time = :start_time, 
                end_time = :end_time, 
                location = :location, 
                image_id = :image_id,
                completed = :completed
            WHERE id = :id";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":id", $entity->getId());
    $statement->bindValue(':name', $entity->getName());
    $statement->bindValue(':description', $entity->getDescription());
    $statement->bindValue(':date', $entity->getDate()->format('Y-m-d'));
    $statement->bindValue(':start_time', $entity->getStartTime());
    $statement->bindValue(':end_time', $entity->getEndTime());
    $statement->bindValue(':location', $entity->getLocation());
    $statement->bindValue(':image_id', $entity->getImageId());
    $statement->bindValue(':completed', $entity->getCompleted(), PDO::PARAM_BOOL);
    $statement->execute();
  }
}