<?php
namespace App\Model\Service;

use App\Model\Entity\Participant;
use App\Model\Entity\ParticipantCollection;
use App\Model\Mapper\Participant as ParticipantMapper;
use App\Model\Mapper\ParticipantCollection as ParticipantCollectionMapper;

class ParticipantService
{
  public function __construct(
    private ParticipantMapper $mapper,
    private ParticipantCollectionMapper $collectionMapper,
  ) { }

  public function addRegistration(int $eventId, int $userId): Participant
  {
    $participant = new Participant();

    $participant->setEventId($eventId);
    $participant->setUserId($userId);

    $this->mapper->store($participant);

    return $participant;
  }

  public function getParticipantsByEventId(int $id): ParticipantCollection
  {
    $participants = new ParticipantCollection();

    $participants->forEventId($id);

    $this->collectionMapper->fetch($participants);

    return $participants;
  }

  public function registrationExists(int $eventId, int $userId): bool
  {
    $participant = new Participant();

    $participant->setEventId($eventId);
    $participant->setUserId($userId);

    return $this->mapper->exists($participant);
  }
}