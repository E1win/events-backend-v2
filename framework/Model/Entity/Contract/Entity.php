<?php
namespace Framework\Model\Entity\Contract;

interface Entity extends HasId, Arrayable, \JsonSerializable
{
  public function toArray(): array;

  public function jsonSerialize(): mixed;
}