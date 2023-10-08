<?php
namespace Framework\Auth\Model\Service;

/**
 * Handles things like: 
 * userExists
 * loginWithPassword(User $user, string $password)
 * Or should AuthService handle things like that?
 * 
 * does not handle: creating sessions
 */

use Framework\Auth\Model\Entity\User;
use Framework\Auth\Model\Mapper\User as UserMapper;
use Framework\Auth\Exception\UserNotFoundException;
use Ramsey\Uuid\Uuid;

class UserService
{
  const SESSION_LIFESPAN = 14400; // seconds, 4 hours
  const SESSION_COOKIE_NAME = 'EventsCMSSession';


  public function __construct(
    private UserMapper $mapper
  ) { }

  public function getUserById(int $id): User
  {
    $user = new User($id);

    $this->mapper->fetch($user);

    return $user;
  }

  public function getUserByEmail(string $email): User
  {
    $user = new User;

    $user->setEmail($email);

    $this->mapper->fetch($user);

    if ($user->getId() === null) {
      throw new UserNotFoundException();
    }

    return $user;
  }

  public function getUserBySessionUuid(string $uuid): User
  {
    $user = new User;

    $user->setSessionUuid($uuid);

    $this->mapper->fetch($user);

    if ($user->getId() === null) {
      throw new UserNotFoundException();
    }

    return $user;
  }

  public function createSession(User $user): User
  {
    $user->setSessionUuid($this->generateUuid());
    
    return $this->updateSession($user);
  }
  
  public function updateSession(User $user): User
  {
    $user->setExpiresOn(time() + UserService::SESSION_LIFESPAN);

    $this->mapper->store($user);

    $this->setSessionCookie($user);
    
    return $user;
  }

  private function generateUuid(): string
  {
    return Uuid::uuid4()->toString();
  }

  public function removeSession(User $user): User
  {
    $this->unsetSessionCookie();

    return $user;
  }

  private function setSessionCookie(User $user)
  {
    setcookie(
      UserService::SESSION_COOKIE_NAME, 
      $user->getSessionUuid(), 
      array(
        'expires' => $user->getExpiresOn(),
        'httponly' => true,
      ),
    );
  }

  private function unsetSessionCookie()
  {
    setcookie(
      UserService::SESSION_COOKIE_NAME,
      "",
      array(
        'expires' => time() - 4400,
        'httponly' => true,
      )
    );
  }
}