<?php
namespace Framework\FileSystem\Contract;

use Psr\Http\Message\UploadedFileInterface;

interface FileSystemManager
{
  public function upload(UploadedFileInterface $file);

  public function retrieve($something): UploadedFileInterface;
}