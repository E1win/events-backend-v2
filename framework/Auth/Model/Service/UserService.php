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
use Framework\Auth\Model\Entity\UserCollection;
use Framework\Auth\Model\Mapper\UserCollection as UserCollectionMapper;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class UserService
{
  const SESSION_LIFESPAN = 14400; // seconds, 4 hours
  const SESSION_TOKEN_NAME = 'EventsCMSSession';


  public function __construct(
    private UserMapper $mapper,
    private UserCollectionMapper $collectionMapper,
  ) { }

  public function getAllUsers(): UserCollection
  {
    $collection = new UserCollection();
    $this->collectionMapper->fetch($collection);

    return $collection;
  }

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

  public function getUserByToken(string $token): User
  {
    $user = new User;

    $user->setSessionUuid($token);

    $this->mapper->fetch($user);

    if ($user->getId() === null) {
      throw new UserNotFoundException();
    }

    return $user;
  }

  public function createUser(
    string $email,
    string $hash,
    string $firstName,
    ?string $prefix,
    string $lastName,
  ): User {
    $user = new User;
    
    // fill user object

    // Also create sessions, etc.

    // mapper->store;

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

    // $this->setSessionCookie($user);
    
    return $user;
  }

  private function generateUuid(): string
  {
    return Uuid::uuid4()->toString();
  }

  public function removeSession(User $user): User
  {
    // $this->unsetSessionCookie();

    return $user;
  }

  public function sessionTokenInRequest(ServerRequestInterface $request): bool
  {
    return $request->hasHeader('Authorization') || isset($request->getCookieParams()[UserService::SESSION_TOKEN_NAME]);
  }

  public function getSessionTokenFromRequest(ServerRequestInterface $request): ?string
  {
    if ($request->hasHeader('Authorization')) {
      return $request->getHeaderLine('Authorization');
    }

    return $request->getCookieParams()[UserService::SESSION_TOKEN_NAME];
  }

  private function setSessionCookie(User $user)
  {
    setcookie(
      UserService::SESSION_TOKEN_NAME, 
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
      UserService::SESSION_TOKEN_NAME,
      "",
      array(
        'expires' => time() - 4400,
        'httponly' => true,
      )
    );
  }
}