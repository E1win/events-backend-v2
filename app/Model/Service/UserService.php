<?php
namespace App\Model\Service;

/**
 * Handles things like: 
 * userExists
 * loginWithPassword(User $user, string $password)
 * Or should AuthService handle things like that?
 * 
 * does not handle: creating sessions
 */

use App\Model\Entity\User;
use App\Model\Mapper\User as UserMapper;

class UserService
{
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

    return $user;
  }
}