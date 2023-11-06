<?php
namespace App\Model\Mapper;

use App\Model\Entity\Image as ImageEntity;
use Framework\Model\Mapper\DataMapper;
use PDO;

class Image extends DataMapper
{
  public function store(ImageEntity $image)
  {
    $sql = "INSERT INTO {$this->table} (name, content_type) VALUES (:name, :content_type)";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(':name', $image->getName(), PDO::PARAM_STR);
    $statement->bindValue(':content_type', $image->getContentType(), PDO::PARAM_STR);
    $statement->execute();

    $image->setId($this->connection->lastInsertId());
  }

  public function fetch(ImageEntity $image)
  {
    $sql = "SELECT * FROM {$this->table} WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":id", $image->getId(), PDO::PARAM_INT);
    $statement->execute();

    $data = $statement->fetch();

    if ($data) {
      $this->applyValues($image, $data);
    }
  }
}