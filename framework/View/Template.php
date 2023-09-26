<?php
namespace Framework\View;

use Framework\Message\Response;
use Framework\View\Contract\TemplateInterface;
use Framework\View\Contract\TemplateLoaderInterface;
use Framework\View\Engine\Contract\SourceInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * TODO: Children template elements
 * {% for event in events %}
 */

class Template implements TemplateInterface
{
  private array $variables = [];
  private array $parameters = [];

  private ?TemplateInterface $parent = null;
  private TemplateLoaderInterface $templateLoader;

  private SourceInterface $source;

  private string $parsedCode = '';

  public function __construct(
    TemplateLoaderInterface $templateLoader, 
    SourceInterface $source
  ) {
    $this->templateLoader = $templateLoader;
    $this->source = $source;
  }

  /**
   * Parameters assoc array
   * so if in template there's an {{email}}
   * parameters can be ['email' => $emailAddress]
   */
  public function render(array $parameters = []): string
  {
    // First have lexer tokenize rawCode (lexer returns TokenStream)
    // Parses goes through TokenStream
    // ...

    return $this->parsedCode;
  }

  public function __toString(): string
  {
    if ($this->parsedCode != '') {
      return $this->parsedCode;
    }

    return $this->render();
  }
}