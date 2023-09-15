<?php
namespace Framework\Container\Contract;

interface ContainerResourceInterface
{
  public function setName(string $className): self;

  public function getName(): string;

  public function setParameter(string $key, mixed $value): self;

  public function getParameters(): array|null;

  public function hasParameters(): bool;
}