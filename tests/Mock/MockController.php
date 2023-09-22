<?php
namespace Tests\Mock;

use Framework\Controller\Controller;
use Psr\Http\Message\ServerRequestInterface;

class MockController extends Controller
{
  public function index(ServerRequestInterface $request)
  {
    return '<br>In MockController.<br>';
  }
}
