<?php

// TODO: Fix a bug where
// if web is first, it always matches that

/**
 * probably don't need prefix here
 * since it's also set in the routes config itself.
 */

// "file" => "prefix"
return [
  "api.php" => '/api',
  "web.php" => '',
];