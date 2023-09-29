<?php
namespace App\Model\Service;

use App\Model\Entity\Image;
use App\Model\Mapper\Image as ImageMapper;
use Framework\FileSystem\Contract\FileSystemManager;
use Psr\Http\Message\UploadedFileInterface;

class ImageService
{
  public function __construct(
    private ImageMapper $mapper,
    private FileSystemManager $fileSystemManager
  ) { }

  public function getImageById(int $id): UploadedFileInterface
  {
    $image = new Image($id);

    $this->mapper->fetch($image);

    $path = $image->getId() . '.' . $image->getFileExtension();

    $file = $this->fileSystemManager->retrieve($path);

    return $file;
  }

  public function uploadImage(UploadedFileInterface $file): Image
  {
    $image = new Image();

    $image->setName($file->getClientFilename());
    $image->setFileExtension($file->getClientMediaType());

    $this->mapper->store($image);

    var_dump($image);

    $this->fileSystemManager->upload($file, $image->getId(), 'images/');

    return $image;
  }
}