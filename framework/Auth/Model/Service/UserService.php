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

  public function userWithEmailExists($email): bool
  {
    $user = new User;

    $user->setEmail($email);

    return $this->mapper->exists($user);
  }

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

    $user->unsetSensitiveData();

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

    // TODO: Check if token is not expired.

    if ($user->getId() === null) {
      throw new UserNotFoundException();
    }

    return $user;
  }

  public function changeUserRoleById(int $id, int $roleId): User
  {
    $user = $this->getUserById($id);

    $user->setRoleId($roleId);

    $this->mapper->updateRoleId($user);

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
    
    // Fill User entity with data
    $user->setEmail($email);
    $user->setPassword($hash);
    $user->setFirstName($firstName);
    if ($prefix != null) {
      $user->setPrefix($prefix);
    }
    $user->setLastName($lastName);

    // Create session
    $user->setSessionUuid($this->generateUuid());
    $user->setExpiresOn(time() + UserService::SESSION_LIFESPAN);

    $this->mapper->store($user);

    return $user;
  }

  public function updateUser(
    User $user, 
    string $firstName,
    ?string $prefix,
    string $lastName
  ): User {

    $user->setFirstName($firstName);
    $user->setPrefix($prefix);
    $user->setLastName($lastName);

    $this->mapper->update($user);

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
    // return Uuid::uuid4()->toString();
    $data = openssl_random_pseudo_bytes(16, $strong);
    assert($data !== false && $strong);

    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
      
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
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