<?php
namespace Framework\Auth\Model\Entity;

use Framework\Model\Entity\Collection;
use Framework\Model\Entity\Contract\HasId;

class UserCollection extends Collection
{
  private bool $showSensitiveData = false;

  protected function buildEntity(): HasId
  {
    return new User();
  }

  public function setShowSensitiveData(bool $show) {
    $this->showSensitiveData = $show;
  }

  public function getShowSensitiveData(): bool
  {
    return $this->showSensitiveData;
  }
}