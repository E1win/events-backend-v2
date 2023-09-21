<?php
namespace Framework\Routing;

use Exception;
use Framework\Routing\Contract\RouteGathererInterface;
use Framework\Routing\Contract\RouterInterface;

class RouteGatherer implements RouteGathererInterface
{
  private string $routesDirectory = ROOT_PATH . 'config/routes/';

  public function load(): RouterInterface
  {
    $config = config('routes.php');

    $router = Router::create();

    foreach ($config as $file => $prefix) {
      $router->groupRouter($prefix, $this->loadFromFile($file));
    }

    return $router;
  }

  private function loadFromFile(string $fileName): RouterInterface
  {
    $path = $this->routesDirectory . $fileName;

    if (is_file($path)) {
      return include($path);
    }

    throw new Exception("Failed to find routes in: '{$path}'.");
  }
}