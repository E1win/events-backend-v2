<?php
namespace Framework\Routing;

use Exception;
use Framework\Routing\Contract\RouteGathererInterface;
use Framework\Routing\Contract\RouterInterface;

class RouteGatherer implements RouteGathererInterface
{
  public function load(): RouterInterface
  {
    $config = config('routes.php');

    $routesDirectory = $config['directory'];

    $router = Router::create();

    foreach ($config['routes'] as $file) {
      $subRouter = $this->loadFromFile($routesDirectory . $file);
      $prefix = $subRouter->getPrefix();
      $router->groupRouter($prefix, $subRouter);
    }

    return $router;
  }

  private function loadFromFile(string $path): RouterInterface
  {
    if (is_file($path)) {
      return include($path);
    }

    throw new Exception("Failed to find routes in: '{$path}'.");
  }
}