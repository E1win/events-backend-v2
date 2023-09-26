<?php
namespace Framework\View;

use Framework\View\Contract\TemplateInterface;
use Framework\View\Contract\TemplateLoaderInterface;
use Framework\View\Engine\Source;
use PHPUnit\Framework\Attributes\Test;

class TemplateLoader implements TemplateLoaderInterface
{
  private $viewPath = ROOT_PATH . "app/View/";

  /**
   * Loads template using filename
   * then fills up parameters array
   */
  public function load(string $fileName): TemplateInterface
  {
    $html = file_get_contents($this->viewPath . $fileName);

    $source = new Source($html, $fileName);

    $template = new Template($this, $source);

    return $template;
  }
}