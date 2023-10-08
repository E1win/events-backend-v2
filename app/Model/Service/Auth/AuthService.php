<?php
namespace App\Model\Service\Auth;

use App\Model\Entity\User;
use App\Model\Exception\InvalidPasswordException;
use App\Model\Exception\SessionExpiredException;
use App\Model\Service\UserService;

// TODO: Maybe session data should be in user table

class AuthService
{
  public function __construct(
    private UserService $userService,
  ) { }

  public function loginWithSessionUuid(string $sessionUuid): User
  {
    $user = $this->userService->getUserBySessionUuid($sessionUuid);

    return $this->loginWithUser($user);
  }

  // Maybe for if user is already retrieved previously in
  // UserMiddleware? 
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

  public function register()
  {
    // . . .
  }

}