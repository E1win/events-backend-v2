<?php
namespace Framework\Message\Stream;

use Framework\Message\Stream;

class InputStream extends Stream
{
  public function __construct()
  {
    $input = fopen('php://input', 'rb');

    $handle = fopen('php://temp', 'r+b');

    stream_copy_to_stream($input, $handle);

    parent::__construct($handle);

    $this->rewind();
  }
}