<?php
namespace Framework\View\Contract;

interface TemplateLoaderInterface
{
  public function load(string $filename): TemplateInterface;
}