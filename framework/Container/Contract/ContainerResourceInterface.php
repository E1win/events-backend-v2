<?php
namespace Framework\Container\Contract;

interface ContainerResourceInterface
{
  public function setParameter(string $key, mixed $value): self;

  public function getParameters(): array|null;

  public function hasParameters(): bool;
}