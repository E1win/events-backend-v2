<?php
namespace Framework\FileSystem;

use Dotenv\Exception\InvalidFileException;
use Framework\FileSystem\Contract\FileSystemManager as ContractFileSystemManager;
use Framework\Message\Stream;
use Framework\Message\UploadedFile;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Handles things like uploading images to storage
 */
class FileSystemManager implements ContractFileSystemManager
{
  private string $storageDir = '';
  private array $allowedFileExtensions = [];

  // public function __construct()
  // {
    
  // }

  public function upload(UploadedFileInterface $file, string $fileName, string $directory = "")
  {
    $config = config('filesystem.php');

    $this->storageDir = $config['directory'];
    $this->allowedFileExtensions = $config['allowed_file_extensions'];

    if (!key_exists($file->getClientMediaType(), $this->allowedFileExtensions)) {
      throw new InvalidFileException("File extension '{$file->getClientMediaType()}' not allowed");
    }

    $fileExtension = $this->allowedFileExtensions[$file->getClientMediaType()];

    $path = $this->storageDir . $directory . $fileName . "." . $fileExtension;


    $file->moveTo($path);
  }

  public function load($path): UploadedFileInterface
  {
    return new UploadedFile(new Stream('t'));
  }
}