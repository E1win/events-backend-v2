<?php
namespace Framework\Auth\Model\Mapper;

use Framework\Auth\Model\Entity\User as UserEntity;
use Framework\Model\Mapper\DataMapper;
use PDO;

class User extends DataMapper
{
  public function fetch(UserEntity $entity)
  {
    if ($entity->getEmail() !== null) {
      $this->fetchByEmail($entity);
    } else if ($entity->getSessionUuid() !== null) {
      $this->fetchBySessionUuid($entity);
    } else if ($entity->getId() !== null) {
      $this->fetchById($entity);
    }
  }

  private function fetchByEmail(UserEntity $entity)
  {
    $sql = "SELECT * FROM {$this->table} WHERE email = :email";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":email", $entity->getEmail(), PDO::PARAM_STR);
    $statement->execute();

    $data = $statement->fetch();

    if ($data) {
      $this->applyValues($entity, $data);
    }
  }

  private function fetchBySessionUuid(UserEntity $entity)
  {
    $sql = "SELECT * FROM {$this->table} WHERE session_uuid = :session_uuid";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(':session_uuid', $entity->getSessionUuid(), PDO::PARAM_STR);
    $statement->execute();

    $data = $statement->fetch();

    if ($data) {
      $this->applyValues($entity, $data);
    }
  }

  private function fetchById(UserEntity $entity)
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

  public function store(UserEntity $entity)
  {
    if ($entity->getId() === null) {
      $this->createUser($entity);
    } else {
      $this->updateSession($entity);
    }
  }

  private function createUser(UserEntity $entity)
  {
    $sql = "INSERT INTO {$this->table}
              (email, password, session_uuid, expires_on)
            VALUES (:email, :password, :session_uuid, :expires_on)";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":email", $entity->getEmail(), PDO::PARAM_STR);
    $statement->bindValue(":password", $entity->getPassword(), PDO::PARAM_STR);
    $statement->bindValue(':session_uuid', $entity->getSessionUuid(), PDO::PARAM_STR);
    $statement->bindValue(':expires_on', $entity->getExpiresOn(), PDO::PARAM_INT);

    $statement->execute();

    $entity->setId($this->connection->lastInsertId());
  }

  private function updateSession(UserEntity $entity)
  {
    $sql = "UPDATE {$this->table}
              SET session_uuid = :session_uuid,
                  expires_on = :expires_on
              WHERE id = :id";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(":id", $entity->getId(), PDO::PARAM_INT);
    $statement->bindValue(':session_uuid', $entity->getSessionUuid(), PDO::PARAM_STR);
    $statement->bindValue(':expires_on', $entity->getExpiresOn(), PDO::PARAM_INT);

    $statement->execute();
  }
}