<?php
namespace Framework\View;

use Framework\Auth\Model\Entity\User;
use Framework\Message\Contract\HtmlResponseFactoryInterface;
use Framework\View\Contract\ViewRenderer as ContractViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class ViewRenderer implements ContractViewRenderer
{
  
  public function __construct(
    private Environment $view,
    private HtmlResponseFactoryInterface $responseFactory,
  ) { }

  public function load(string $url, ?ServerRequestInterface $request = null, array $context = []): ResponseInterface
  {
    // Add things like user to context here.
    // and a view bools like loggedIn maybe.
    
    if ($request) {
      $user = $this->getUserFromRequest($request);
      
      if ($user != null) {
        $context['user'] = $user;
        $context['loggedIn'] = true;
      }
    }

    $html = $this->view->render($url, $context);

    return $this->responseFactory->createHtmlResponse(200, $html);
  }

  private function getUserFromRequest(ServerRequestInterface $request): ?User
  {
    return $request->getAttribute('user');
  }

}