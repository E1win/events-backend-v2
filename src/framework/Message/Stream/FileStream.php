<?php
namespace Framework\Message\Stream;

use Framework\Message\Stream;
use InvalidArgumentException;

class FileStream extends Stream
{
  public function __construct(string $filename, string $mode)
  {
    $resource = @fopen($filename, $mode);

    if (!is_resource($resource)) {
      throw new InvalidArgumentException(sprintf(
        'Unable to open the file "%s" in the mode "%s"',
        $filename,
        $mode
      ));
    }

    parent::__construct($resource);
  }
}