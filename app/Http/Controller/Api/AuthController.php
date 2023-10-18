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

  public function login(ServerRequestInterface $request): ResponseInterface
  {
    $body = $request->getParsedBody();

    $email = $body['email'];
    $password = $body['password'];

    $user = $this->authService->loginWithEmailAndPassword($email, $password);

    // maybe set session token in header here
    // but also maybe not necessary, since client should
    // save token and everything in storage and set
    // authorization headers

    return $this->responseFactory->createJsonResponse(
      [
        'user' => $user,
        'status' => 'success'
      ]
    );
    // )->withAddedHeader('Authorization', $user->getSessionUuid());
  }
}