<?php
namespace App\Model\Service\Auth;

use App\Model\Entity\Auth\Session;
use App\Model\Entity\User;
use App\Model\Exception\InvalidPasswordException;
use App\Model\Exception\SessionExpiredException;
use App\Model\Service\UserService;

// TODO: Maybe session data should be in user table

class AuthService
{
  public function __construct(
    private SessionService $sessionService,
    private UserService $userService,
  ) { }

  public function loginWithSession(Session $session): User
  {
    if ($session->isExpired()) {
      $this->sessionService->removeSessionByUuid($session->getSessionUuid());

      throw new SessionExpiredException();
    }

    return $this->userService->getUserById($session->getUserId());
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

    $this->sessionService->createSessionAndSetCookie($user->getId());

    return $user;
  }

  public function logout(Session $session)
  {
    $this->sessionService->removeSessionByUuid($session->getSessionUuid());
    // delete session from database

    // . . .
  }

  public function register()
  {
    // . . .
  }

  
}