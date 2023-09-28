<?php
namespace App\Model\Service;

use App\Model\Entity\ParticipantCollection;
use App\Model\Mapper\ParticipantCollection as ParticipantCollectionMapper;

class ParticipantService
{
  public function __construct(
    private ParticipantCollectionMapper $mapper,
  ) { }

  public function getParticipantsByEventId(int $id)
  {
    $collection = new ParticipantCollection();

    $collection->forEventId($id);

    $this->mapper->fetch($collection);

    return $collection;
  }
}