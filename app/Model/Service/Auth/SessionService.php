<?php
namespace App\Model\Service\Auth;

use App\Model\Entity\Auth\Session;
use App\Model\Mapper\Auth\Session as SessionMapper;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Rfc4122\UuidInterface;
use Ramsey\Uuid\Uuid;

class SessionService
{
  const DEFAULT_SESSION_LIFESPAN = 14400; // seconds, 4 hours
  const DEFAULT_SESSION_COOKIE_NAME = 'EventsCMSSession';

  public function __construct(
    private SessionMapper $mapper,
    private int $sessionLifespan = SessionService::DEFAULT_SESSION_LIFESPAN,
    private string $sessionCookieName = SessionService::DEFAULT_SESSION_COOKIE_NAME
  )
  {
  }

  public function getSessionByUuid(string $uuid): Session
  {
    $session = new Session;

    $session->setSessionUuid($uuid);

    $this->mapper->fetch($session);

    return $session;
  }

  public function createSessionAndSetCookie(int $userId): Session
  {
    $session = $this->createSession($userId);

    $this->setSessionCookie($session);

    return $session;
  }

  public function createSession(int $userId): Session
  {
    $session = new Session;
    $session->setUserId($userId);
    $session->setSessionUuid($this->generateUuid());
    $session->setExpiresOn(time() + $this->sessionLifespan);

    $this->mapper->store($session);

    return $session;
  }

  private function setSessionCookie(Session $session)
  {
    setcookie(
      $this->sessionCookieName, 
      $session->getSessionUuid(), 
      array(
        'expires' => $session->getExpiresOn(),
        'httponly' => true,
      ),
    );
  }

  public function sessionExistsInRequest(ServerRequestInterface $request): bool
  {
    $cookies = $request->getCookieParams();

    return isset($cookies[$this->sessionCookieName]);
  }

  public function getSessionUuidFromRequest(ServerRequestInterface $request): string
  {
    return $request->getCookieParams()[$this->sessionCookieName];
  }

  private function generateUuid(): string
  {
    return Uuid::uuid4()->toString();
  }
}