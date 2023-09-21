<?php
namespace Framework\Routing\Contract;

interface RouteGathererInterface
{
  /**
   * Load all routes from files
   * set in config/routes.php
   */
  public function load(): RouterInterface;
}