<?php
namespace App\Model\Service;

use App\Model\Entity\ParticipantCollection;
use App\Model\Mapper\ParticipantCollection as ParticipantCollectionMapper;

class ParticipantService
{
  public function __construct(
    private ParticipantCollectionMapper $mapper,
  ) { }

  public function getParticipantsByEventId(int $id): ParticipantCollection
  {
    $participants = new ParticipantCollection();

    $participants->forEventId($id);

    $this->mapper->fetch($participants);

    return $participants;
  }
}