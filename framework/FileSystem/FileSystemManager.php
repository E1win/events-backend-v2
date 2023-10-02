<?php
namespace Framework\FileSystem;

use Dotenv\Exception\InvalidFileException;
use Framework\FileSystem\Contract\FileSystemManager as ContractFileSystemManager;
use Framework\Message\Stream;
use Framework\Message\UploadedFile;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Handles things like uploading images to storage
 */
class FileSystemManager implements ContractFileSystemManager
{
  private string $storageDir = '';
  private array $allowedFileExtensions = [];
  private StreamFactoryInterface $streamFactory;

  public function __construct(StreamFactoryInterface $streamFactory) 
  {
    $this->streamFactory = $streamFactory;

    $config = config('filesystem.php');

    $this->storageDir = $config['directory'];
    $this->allowedFileExtensions = $config['allowed_file_extensions'];
  }

  public function upload(UploadedFileInterface $file, string $fileName, string $directory = "")
  {
    $path = $this->formatPath($fileName, $file->getClientMediaType(), $directory);

    $file->moveTo($path);
  }

  public function load(string $fileName, string $fileMediaType, string $directory = ""): StreamInterface
  {
    $path = $this->formatPath($fileName, $fileMediaType, $directory);
    
    return $this->streamFactory->createStreamFromFile($path);
  }

  private function formatPath(string $fileName, string $fileMediaType, string $directory = ""): string
  {
    if (!key_exists($fileMediaType, $this->allowedFileExtensions)) {
      throw new InvalidFileException("File extension '{$fileMediaType}' not allowed");
    }

    $fileExtension = $this->allowedFileExtensions[$fileMediaType];
    $path = $this->storageDir . $directory . $fileName . ".". $fileExtension;

    return $path;
  }
}