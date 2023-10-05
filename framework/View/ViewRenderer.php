<?php
namespace Framework\View;

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

  public function load(string $url, array $context = [], ?ServerRequestInterface $request = null): ResponseInterface
  {
    // Add others here like user.

    $html = $this->view->render($url, $context);

    return $this->responseFactory->createHtmlResponse(200, $html);
  }
}