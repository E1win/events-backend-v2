<?php
namespace App\Model\Mapper\Auth;

use App\Model\Entity\Auth\Session as EntitySession;
use Exception;
use Framework\Model\Mapper\DataMapper;
use PDO;

class Session extends DataMapper
{
  public function exists(EntitySession $session)
  {

  }

  public function fetch(EntitySession $session)
  {
    if (!is_null($session->getSessionUuid())) {
      $this->fetchByUuid($session);
      return;
    }

    throw new Exception('SessionUuid not set');
  }
  
  public function store(EntitySession $session)
  {
    // TODO: check if session already exists for user,
    // if it does, just update previous session with new information
    // so we only have one session per user.

    // But can they then have sessions on multiple devices?

    // TODO: We can also just have user_id as primary key
    // in session table, since there's only one session per user.

    // var_dump($session);

    $sql = "INSERT INTO {$this->table} 
      (session_uuid, expires_on, user_id) 
      VALUES (:session_uuid, :expires_on, :user_id)";

    $statement = $this->connection->prepare($sql);

    $statement->bindValue(':session_uuid', $session->getSessionUuid(), PDO::PARAM_STR);
    $statement->bindValue(':expires_on', $session->getExpiresOn(), PDO::PARAM_INT);
    $statement->bindValue(':user_id', $session->getUserId(), PDO::PARAM_INT);
    $statement->execute();

    $session->setId($this->connection->lastInsertId());
  }

  public function remove(EntitySession $session)
  {
    if (!is_null($session->getSessionUuid())) {
      $this->removeByUuid($session);
      return;
    }

    throw new Exception('SessionUuid not set');
  }

  private function fetchByUuid(EntitySession $session)
  {
    $sql = "SELECT * FROM {$this->table} WHERE session_uuid = :session_uuid";
    
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(':session_uuid', $session->getSessionUuid(), PDO::PARAM_STR);
    $statement->execute();

    $data = $statement->fetch();

    if ($data) {
      $this->applyValues($session, $data);
    }
  }

  private function removeByUuid(EntitySession $session)
  {
    $sql = "DELETE FROM {$this->table} WHERE session_uuid = :session_uuid";
    $statement = $this->connection->prepare($sql);

    $statement->bindValue(':session_uuid', $session->getSessionUuid());
    $statement->execute();
  }
}