<?php
namespace App\Http\Controller\Api;

use Exception;
use Framework\Auth\Model\Service\UserService;
use Framework\Controller\Controller;
use Framework\Message\Contract\JsonResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
  public function __construct(
    private JsonResponseFactoryInterface $responseFactory,
    private UserService $userService
  ) {}

  /**
   * Return a list of all users.
   */
  public function index(ServerRequestInterface $request): ResponseInterface
  {
    $users = $this->userService->getAllUsers();

    return $this->responseFactory->createJsonResponse(
      $users
    );
  }

  public function changeUserRole(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $body = $request->getParsedBody();

    $roleId = $body['roleId'];

    $user = $this->userService->changeUserRoleById($id, $roleId);

    return $this->responseFactory->createJsonResponse(
      $user
    );
  }

  public function updateUser(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $body = $request->getParsedBody();

    $user = $request->getAttribute('user');

    // Is user from request same as user id from url
    if ($user->getId() === $id) {
      // if so, you can update user
      $user = $this->userService->updateUser($user, $body['firstName'], $body['prefix'], $body['lastName']);
    } else {
      throw new Exception("Logged in user doesn't match URL id", 500);
    }

    return $this->responseFactory->createJsonResponse(
      $user
    );
  }
}