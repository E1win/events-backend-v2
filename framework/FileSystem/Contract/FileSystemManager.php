<?php
namespace Framework\FileSystem\Contract;

use Psr\Http\Message\UploadedFileInterface;

interface FileSystemManager
{
  public function upload(UploadedFileInterface $file, string $fileName, string $directory = "");

  public function retrieve($path): UploadedFileInterface;
}