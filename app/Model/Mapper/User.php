<?php
namespace App\Model\Mapper;

use App\Model\Entity\User as UserEntity;
use Framework\Model\Mapper\DataMapper;
use PDO;

class User extends DataMapper
{
  public function fetch(UserEntity $user)
  {
    if (! is_null($user->getEmail())) {
      $this->fetchByEmail($user);
      return;
    } else if (! is_null($user->getId())) {
      $this->fetchById($user);
    }
  }

  private function fetchByEmail(UserEntity $user)
  {
    $sql = "SELECT * FROM {$this->table} WHERE email = :email";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
    $statement->execute();

    $data = $statement->fetch();

    if ($data) {
      $this->applyValues($user, $data);
    }
  }

  private function fetchById(UserEntity $user)
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