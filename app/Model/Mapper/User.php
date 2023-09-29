<?php
namespace App\Model\Mapper;

use App\Model\Entity\User as UserEntity;
use Framework\Model\Mapper\DataMapper;
use PDO;

class User extends DataMapper
{
  public function fetch(UserEntity $user)
  {
    $sql = "SELECT * FROM {$this->table} WHERE id = :id";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":id", $user->getId(), PDO::PARAM_INT);
    $statement->execute();

    $data = $statement->fetch();

    if ($data) {
      $this->applyValues($user, $data);
    }
  }
}