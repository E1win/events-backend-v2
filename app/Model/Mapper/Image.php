<?php
namespace App\Model\Mapper;

use App\Model\Entity\Image as ImageEntity;
use Framework\Model\Mapper\DataMapper;
use PDO;

class Image extends DataMapper
{
  public function delete(ImageEntity $entity)
  {
    $sql = "DELETE FROM {$this->table} WHERE id = :id";

    $statement = $this->connection->prepare($sql);
    $statement->bindValue(':id', $entity->getId());

    $statement->execute();
  }

  public function store(ImageEntity $entity)
  {
    $sql = "INSERT INTO {$this->table} (name, content_type) VALUES (:name, :content_type)";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(':name', $entity->getName(), PDO::PARAM_STR);
    $statement->bindValue(':content_type', $entity->getContentType(), PDO::PARAM_STR);
    $statement->execute();

    $entity->setId($this->connection->lastInsertId());
  }

  public function fetch(ImageEntity $entity)
  {
    $sql = "SELECT * FROM {$this->table} WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":id", $entity->getId(), PDO::PARAM_INT);
    $statement->execute();

    $data = $statement->fetch();

    if ($data) {
      $this->applyValues($entity, $data);
    }
  }

  public function remove(ImageEntity $entity)
  {
    // blahblahblahblahbalhbalbhah
  }
}