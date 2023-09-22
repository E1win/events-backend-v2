<?php
namespace Tests\Unit\Routing;

use Framework\Routing\Route;
use Framework\Routing\Router;
use PHPUnit\Framework\TestCase;
use Tests\Mock\MockController;

class RouterTest extends TestCase
{
  private Router $router;

  protected function setUp(): void
  {
    parent::setUp();

    $this->router = Router::create();
  }

  /** @test */
  public function it_registers_a_route(): void
  {
    $this->router->get("/", [MockController::class, 'index']);

    $expected = [
      new Route('GET', "/", [MockController::class, 'index'])
    ];
  }
}