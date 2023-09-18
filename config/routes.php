<?php

use App\Http\Controller\EventController;

return [
  "/" => [
    "methods" => ['GET', 'POST'],
    "action" => [
      App\Http\Controller\EventController::class,
      "show"
    ],
  ],
];