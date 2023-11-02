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

    // filter certain info out of user info (like passwords)

    return $this->responseFactory->createJsonResponse(
      $users
    );
  }
}