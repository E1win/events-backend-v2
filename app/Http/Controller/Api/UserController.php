<?php
namespace App\Http\Controller\Api;

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
}