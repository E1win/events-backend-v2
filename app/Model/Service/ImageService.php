<?php
namespace App\Model\Service;

use App\Model\Entity\Image;
use App\Model\Mapper\Image as ImageMapper;
use Framework\FileSystem\Contract\FileSystemManager;
use Psr\Http\Message\UploadedFileInterface;

class ImageService
{
  private string $imagesDir = "images/";

  public function __construct(
    private ImageMapper $mapper,
    private FileSystemManager $fileSystemManager
  ) { }

  public function loadBase64EncodedImageById(int $id): string
  {
    $image = new Image($id);

    $this->mapper->fetch($image);

    $fileStream = $this->fileSystemManager->load($image->getId(), $image->getContentType(), $this->imagesDir);

    $imageData = $fileStream->getContents();

    $base64Data = base64_encode($imageData);

    $imageSource = "data:{$image->getContentType()};base64,{$base64Data}";

    return $imageSource;
  }

  public function uploadImage(UploadedFileInterface $file): Image
  {
    $image = new Image();

    $image->setName($file->getClientFilename());
    $image->setContentType($file->getClientMediaType());

    $this->mapper->store($image);

    $this->fileSystemManager->upload($file, $image->getId(), $this->imagesDir);

    return $image;
  }
}