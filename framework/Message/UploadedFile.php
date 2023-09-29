<?php
namespace Framework\Message;

use Framework\Message\Stream\FileStream;
use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use RuntimeException;

class UploadedFile implements UploadedFileInterface
{
  public const UPLOAD_ERRORS = [
    UPLOAD_ERR_OK => 'No error',
    UPLOAD_ERR_INI_SIZE => 'Uploaded file exceeds the upload_max_filesize directive in the php.ini',
    UPLOAD_ERR_FORM_SIZE => 'Uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form',
    UPLOAD_ERR_PARTIAL => 'Uploaded file was only partially uploaded',
    UPLOAD_ERR_NO_FILE => 'No file was uploaded',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary directory',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
    UPLOAD_ERR_EXTENSION => 'File upload was stopped by a PHP extension',
  ];

  /**
   * The file stream
   */
  private ?StreamInterface $stream = null;

  /**
   * The file size
   */
  private ?int $size;

  /**
   * The file's error code
   */
  private int $errorCode;

  /**
   * The file's error message
   */
  private string $errorMessage;

  /**
   * The client's file name
   */
  private ?string $clientFilename;

  /**
   * The client's file media type
   */
  private ?string $clientMediaType;

  public function __construct(
    ?StreamInterface $stream,
    ?int $size = null,
    int $error = UPLOAD_ERR_OK,
    ?string $clientFilename = null,
    ?string $clientMediaType = null
  ) {
    // It doesn't make sense to keep the stream
    // if the file wasn't successfully uploaded...
    if (UPLOAD_ERR_OK === $error) {
      $this->stream = $stream;
    }

    $this->size = $size;
    $this->errorCode = $error;
    $this->errorMessage = self::UPLOAD_ERRORS[$error] ?? 'Unknown error';
    $this->clientFilename = $clientFilename;
    $this->clientMediaType = $clientMediaType;
  }

  public function getStream(): StreamInterface
  {
    if (UPLOAD_ERR_OK <> $this->errorCode) {
      throw new RuntimeException(sprintf(
        'Uploaded file has no a stream due to the error #%d (%s)',
        $this->errorCode,
        $this->errorMessage
      ));
    }

    if (!isset($this->stream)) {
      throw new RuntimeException(
        'Uploaded file has no a stream because it was already moved'
      );
    }

    return $this->stream;
  }

  /**
   * Moves the file to the given path
   */
  public function moveTo($targetPath): void
  {
    if (UPLOAD_ERR_OK <> $this->errorCode) {
      throw new RuntimeException(sprintf(
        'Uploaded file cannot be moved due to the error #%d (%s)',
        $this->errorCode,
        $this->errorMessage
      ));
    }

    if (!isset($this->stream)) {
      throw new RuntimeException(
        'Uploaded file cannot be moved because it was already moved'
      );
    }

    if (!$this->stream->isReadable()) {
      throw new RuntimeException(
        'Uploaded file cannot be moved because it is not readable'
      );
    }

    try {
      $targetStream = new FileStream($targetPath, 'wb');
    } catch (InvalidArgumentException $e) {
      throw new InvalidArgumentException(sprintf(
        'Uploaded file cannot be moved due to the error: %s',
        $e->getMessage()
      ));
    }

    if ($this->stream->isSeekable()) {
      $this->stream->rewind();
    }

    while (!$this->stream->eof()) {
      $targetStream->write($this->stream->read(4096));
    }

    $targetStream->close();

    /** @var string|null */
    $sourcePath = $this->stream->getMetadata('uri');

    $this->stream->close();
    $this->stream = null;

    if (isset($sourcePath) && is_file($sourcePath)) {
      $sourceDir = dirname($sourcePath);
      if (is_writable($sourceDir)) {
        unlink($sourcePath);
      }
    }
  }

  public function getSize(): ?int
  {
    return $this->size;
  }

  /**
   * Gets the file's error code
   *
   * @return int
   */
  public function getError(): int
  {
    return $this->errorCode;
  }

  /**
   * Gets the client's file name
   *
   * @return string|null
   */
  public function getClientFilename(): ?string
  {
    return $this->clientFilename;
  }

  /**
   * Gets the client's file media type
   *
   * @return string|null
   */
  public function getClientMediaType(): ?string
  {
    return $this->clientMediaType;
  }
}