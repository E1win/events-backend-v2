<?php
namespace Framework\FileSystem\Contract;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

interface FileSystemManager
{
  public function upload(UploadedFileInterface $file, string $fileName, string $directory = "");

  public function load(string $fileName, string $fileMediaType, string $directory = ""): StreamInterface;

  public function getFilePath(string $fileName, string $fileMediaType, string $directory = ""): string;

  public function delete(string $fileName, string $fileMediaType, string $directory): void;
}