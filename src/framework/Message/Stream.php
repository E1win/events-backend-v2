<?php
namespace Framework\Message;

use Psr\Http\Message\StreamInterface;

use InvalidArgumentException;
use RuntimeException;
use Throwable;

class Stream implements StreamInterface
{
  /**
   * The stream resource
   * 
   * @var resource|null
   */
  private $resource;

  /**
   * Signals to close the stream on destruction
   */
  private bool $autoClose;



  public function __construct($resource, bool $autoClose = true)
  {
    if (!is_resource($resource)) {
      throw new InvalidArgumentException('Unexpected stream resource');
    }

    $this->resource = $resource;
    $this->autoClose = $autoClose;
  }

  public function __destruct()
  {
    if ($this->autoClose) {
      $this->close();
    }
  }

  public function create($resource): StreamInterface
  {
    if ($resource instanceof StreamInterface) {
      return $resource;
    }

    return new self($resource);
  }

  /**
   * Detaches a resource from the stream
   * 
   * Returns NULL if the stream is already without a resource.
   */
  public function detach()
  {
    $resource = $this->resource;
    $this->resource = null;

    return $resource;
  }

  /**
   * Closes the stream
   */
  public function close(): void
  {
    $resource = $this->detach();

    if (!is_resource($resource)) {
      return;
    }

    fclose($resource);
  }

  /**
   * Check if the end of stream is reached
   */
  public function eof(): bool
  {
    if (!is_resource($this->resource)) {
      return true;
    }

    return feof($this->resource);
  }

  /**
   * Gets stream pointer position
   */
  public function tell(): int
  {
    if (!is_resource($this->resource)) {
      throw new RuntimeException('Stream has no resource');
    }

    $result = ftell($this->resource);
    if ($result === false) {
      throw new RuntimeException('Unable to get the stream pointer position');
    }

    return $result;
  }

  /**
   * Checks if the stream is seekable
   */
  public function isSeekable(): bool
  {
    if (!is_resource($this->resource)) {
      return false;
    }

    $metadata = stream_get_meta_data($this->resource);

    return $metadata['seekable'];
  }

  /**
   * Moves the stream pointer to the beginning
   */
  public function rewind(): void
  {
    $this->seek(0);
  }

  /**
   * Move the stream pointer to the given position
   */
  public function seek(int $offset, int $whence = SEEK_SET): void
  {
    if (!is_resource($this->resource)) {
      throw new RuntimeException('Stream has no resource');
    }

    if (!$this->isSeekable()) {
      throw new RuntimeException('Stream is not seekable');
    }

    $result = fseek($this->resource, $offset, $whence);

    if ($result !== 0) {
      throw new RuntimeException('Unable to move to the stream pointer position');
    }
  }

  /**
   * Checks if the stream is writable
   */
  public function isWritable(): bool
  {
    if (!is_resource($this->resource)) {
      return false;
    }

    $metadata = stream_get_meta_data($this->resource);

    return strpbrk($metadata['mode'], '+acwx') !== false;
  }

  /**
   * Writes the given string to the stream
   * 
   * Returns the number of bytes written to the stream
   */
  public function write(string $string): int
  {
    if (!is_resource($this->resource)) {
      throw new RuntimeException('Stream has no resource');
    }

    if (!$this->isWritable()) {
      throw new RuntimeException('Stream is not writable');
    }

    $result = fwrite($this->resource, $string);
    if ($result === false) {
      throw new RuntimeException('Unable to write to the stream');
    }

    return $result;
  }

  /**
   * Checks if the stream is readable
   */
  public function isReadable(): bool
  {
    if (!is_resource($this->resource)) {
      return false;
    }

    $metadata = stream_get_meta_data($this->resource);

    return strpbrk($metadata['mode'], '+r') !== false;
  }

  /**
   * Reads the given number of bytes from the stream
   */
  public function read(int $length): string
  {
    if (!is_resource($this->resource)) {
      throw new RuntimeException('Stream has no resource');
    }

    if (!$this->isReadable()) {
      throw new RuntimeException('Stream is not readable');
    }

    $result = fread($this->resource, $length);
    if ($result === false) {
      throw new RuntimeException('Unable to read from the stream');
    }

    return $result;
  }

  /**
   * Reads the remainder of the stream
   */
  public function getContents(): string
  {
    if (!is_resource($this->resource)) {
      throw new RuntimeException('Stream has no resource');
    }

    if (!$this->isReadable()) {
      throw new RuntimeException('Stream is not readable');
    }

    $result = stream_get_contents($this->resource);
    if ($result === false) {
      throw new RuntimeException('Unable to read the remainder of the stream');
    }

    return $result;
  }

  /**
   * Gets the stream metadata
   */
  public function getMetadata(?string $key = null)
  {
    if (!is_resource($this->resource)) {
      return null;
    }

    $metadata = stream_get_meta_data($this->resource);
    if ($key === null) {
      return $metadata;
    }

    return $metadata[$key] ?? null;
  }

  /**
   * Gets the stream size
   * 
   * Returns NULL if the stream doesn't have a resource,
   * or if the stream size cannot be determined.
   */
  public function getSize(): ?int
  {
    if (!is_resource($this->resource)) {
      return null;
    }

    $stats = fstat($this->resource);
    if ($stats === false) {
      return null;
    }

    return $stats['size'];
  }

  /**
   * Converts the stream to a string
   */
  public function __toString(): string
  {
    if (!$this->isReadable()) {
      return '';
    }

    try {
      if ($this->isSeekable()) {
        $this->rewind();
      }

      return $this->getContents();
    } catch (Throwable $e) {
      return '';
    }
  }
}