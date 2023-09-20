<?php
/**
 * Global helper functions
 */

if (! function_exists('redirect')) {
function redirect($url, $permanent = false) {
  header('Location: ' . $url, true, $permanent ? 301: 302);
  exit;
}
}

if (! function_exists('config')) {
  /**
   * Helper function for getting configuration
   */
  function config(string $name) {
    $path = ROOT_PATH . "config/" . $name;

    if (is_dir($path)) {
      return loadAllConfigFromDirectory($path);
    } else if (is_file($path)) {
      return include($path);
    } else {
      throw new Exception("Trying to get invalid configuration: '{$name}'");
    }
  }

  function loadAllConfigFromDirectory($path) {

    $configArray = [];

    foreach(glob($path . "*.php") as $filename) {
      $configArray += include($filename);
    }

    return $configArray;
  }
}