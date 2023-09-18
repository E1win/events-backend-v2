<?php
namespace Framework\Logging;

use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
  public function log($level, string|\Stringable $message, array $context = []): void
  {
    // TODO: Make this create a file somewhere
    // with filename: YEARMONTHDAYTIME-LEVEL

    echo "IN LOGGER: {$level}<br>";
    echo $message;
  }
}