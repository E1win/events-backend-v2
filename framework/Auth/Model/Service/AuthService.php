<?php
namespace Framework\Auth\Model\Service;

use Framework\Auth\Model\Entity\User;
use Framework\Auth\Exception\InvalidPasswordException;
use Framework\Auth\Exception\SessionExpiredException;

class AuthService
{
  public function __construct(
    private UserService $userService,
  ) { }

  public function loginWithSessionUuid(string $sessionUuid): User
  {
    $user = $this->userService->getUserByToken($sessionUuid);

    return $this->loginWithUser($user);
  }

  public function loginWithUser(User $user): User
  {
    if ($user->isSessionExpired()) {
      throw new SessionExpiredException();
    }

    return $user;
  }

  public function loginWithEmailAndPassword(string $email, string $password): User
  {
    $user = $this->userService->getUserByEmail($email);

    return $this->loginWithPassword($user, $password);
  }

  public function loginWithPassword(User $user, string $password): User
  {
    if ($user->matchPassword($password) === false) {
      throw new InvalidPasswordException();
    }

    // Current session isn't expired yet, 
    // probably logging in from different device.
    if (! $user->isSessionExpired()) {
      return $this->userService->updateSession($user);
    }

    return $this->userService->createSession($user);
  }

  public function logout(User $user)
  {
    $this->userService->removeSession($user);
  }

  public function register(
    string $email,
    string $password,
    string $firstName,
    ?string $prefix,
    string $lastName,
  ) {
    $hash = password_hash($password, PASSWORD_DEFAULT);

    return $this->userService->createUser($email, $hash, $firstName, $prefix, $lastName);
  }

}