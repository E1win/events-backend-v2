<?php

return [
  Twig\Environment::class => [
    Twig\Loader\FilesystemLoader::class,
    array(
      'debug' => $_ENV['APP_DEBUG'] === "true"
    )
  ],
  Twig\Loader\FilesystemLoader::class => [
    ROOT_PATH . 'app/View'
  ]
];