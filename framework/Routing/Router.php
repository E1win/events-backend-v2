<?php
namespace Framework\Routing;

use Framework\Middleware\Contract\MiddlewareStackInterface;
use Framework\Middleware\MiddlewareStack;
use Framework\Routing\Contract\RouteInterface;
use Framework\Routing\Contract\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

// Router can also have child routers
// which are called when route isn't found in current route
// so for example:
// MainRouter has two children WebRouter and ApiRouter
// they both have different middlewares
// and the ones that are the same are in MainRouter
// WebRouter and ApiRouter might have more routers again

// Probably just save routes as array, to avoid having to create an object for each route
// When route is matched and going through all routers
// maybe: keep track of all middleware whilst going through
// and create Route object at end

// https://stackoverflow.com/questions/71458028/how-to-use-a-middleware-for-a-specific-route-among-other-ones

// FOR PATTERN MATCHING:
// https://github.com/thephpleague/route/blob/5.x/src/Router.php

// $router->route('/api', function(router $router) OR MAYBE (new Router) {
//    $router->group(SIMILAR BUT GROUP WITH MIDDLEWARE NO PREFIX)

//    $router->get(blah blah blah);
// })

class Router implements RouterInterface
{
  private $prefix = '';

  /** @var RouteInterface[] */
  private array $routes = [];

  /** @var RouterInterface[] */
  private array $groups = [];

  private MiddlewareStackInterface $middlewareStack;

  protected $patternMatchers = [
    // '/{(.+?):number}/'        => '{$1:[0-9]+}',
    // '/{(.+?):word}/'          => '{$1:[a-zA-Z]+}',
    '/{(.+?):number}/'        => '([0-9]{1,6})',
    '/{(.+?):word}/'          => '([a-zA-Z]+)',
  ];

  protected $tokenPattern = '/\{([^:]+):[^}]+\}/';

  // TODO: loadRoutes function.

  public static function create()
  {
    return new Router((new MiddlewareStack()));
  }

  public function __construct(MiddlewareStackInterface $middlewareStack)
  {
    $this->middlewareStack = $middlewareStack;
  }

  public function match(ServerRequestInterface $request): ?RouteInterface
  {
    $path = $request->getUri()->getPath();

    foreach ($this->groups as $prefix => $router) {
      // Check if request target string starts with prefix
      if (substr($path, 0, strlen($prefix)) === $prefix) {
        // TODO: Maybe add middleware from current router
        // to route here???
        $route = $router->match($request);

        if ($route) {
          $this->prependMiddlewaresToRoute($route);
        }

        return $route;
      }
    }

    foreach ($this->routes as $route) {
      if ($route->getMethod() != $request->getMethod()) {
        continue;
      }

      preg_match("@^" . $this->parseRoutePath($route->getPattern()) . "$@", $path, $matches);

      if ($matches) {
        $tokens = $this->getTokenArray($route->getPattern());
        
        // TODO: This can definitely be refactored.
        foreach($matches as $index => $match) {
          // Not interested in the complete match, just the tokens
          if ($index == 0) {
            continue;
          }

          $route->addToken($tokens[$index - 1], $match);
        }
        
        if ($route) {
          $this->prependMiddlewaresToRoute($route);
        }

        return $route;
      }
    }

    return null;
  }

  public function group(string $prefix, callable $callback): RouterInterface
  {
    // TODO: Maybe make this a container->get call?
    // This is probably a lot quicker though
    $subRouter = Router::create()->addPrefix($prefix);

    call_user_func($callback, $subRouter);

    $this->groups[$prefix] = $subRouter;

    return $subRouter;
  }

  public function groupRouter(string $prefix, RouterInterface $router): RouterInterface
  {
    $this->groups[$prefix] = $router;
    
    return $router;
  }

  public function get(string $pattern, mixed $callback): void
  {
    $this->method('GET', $pattern, $callback);
  }

  public function post(string $pattern, mixed $callback): void
  {
    $this->method('POST', $pattern, $callback);
  }

  public function delete(string $pattern, mixed $callback): void
  {
    $this->method('DELETE', $pattern, $callback);
  }

  public function put(string $pattern, mixed $callback): void
  {
    $this->method('PUT', $pattern, $callback);
  }

  public function method(string $method, string $pattern, mixed $callback): void
  {
    // TODO: Check if method is valid

    $this->routes[] = new Route($method, $this->prefix . $pattern, $callback);
  }

  public function addPrefix(string $prefix): RouterInterface
  {
    $this->prefix .= $prefix;

    return $this;
  }

  public function getPrefix(): string
  {
    return $this->prefix;
  }

  public function addMiddleware(string $middleware)
  {
    $this->middlewareStack->append($middleware);
  }

  public function addMiddlewares(array $middlewares)
  {
    $this->middlewareStack->appendArray($middlewares);
  }

  public function getRoutes(): array
  {
    return $this->routes;
  }

  private function prependMiddlewaresToRoute(RouteInterface $route): void
  {
    $routeMiddlewareStack = $route->getMiddlewareStack();

    $middlewareArray = $this->middlewareStack->getStack();

    $routeMiddlewareStack->prependArray($middlewareArray);
  }

  private function parseRoutePath(string $path): string
  {
    return preg_replace(array_keys($this->patternMatchers), array_values($this->patternMatchers), $path);
  }

  private function getTokenArray(string $path): array
  {
    preg_match_all($this->tokenPattern, $path, $matches);

    return $matches[1];
  }
}