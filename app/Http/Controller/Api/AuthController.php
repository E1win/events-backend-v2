<?php
namespace App\Http\Controller\Api;

use Framework\Auth\Model\Service\AuthService;
use Framework\Controller\Controller;
use Framework\Message\Contract\RedirectResponseFactoryInterface;
use Framework\Message\Contract\JsonResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends Controller
{
  public function __construct(
    private AuthService $authService,
    private JsonResponseFactoryInterface $responseFactory,
    private RedirectResponseFactoryInterface $redirectResponseFactory,
  ) {}

  public function logout(ServerRequestInterface $request): ResponseInterface
  {
    $user = $request->getAttribute('user');

    $this->authService->logout($user);

    return $this->responseFactory->createJsonResponse(
      ['status' => 'success']
    );
  }
}