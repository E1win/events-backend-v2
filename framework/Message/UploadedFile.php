<?php
namespace Framework\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

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
}