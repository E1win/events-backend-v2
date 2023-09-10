<?php
namespace App\Message\Response;

use App\Message\Factory as MessageFactory;
use App\Message\Response;
use InvalidArgumentException;
use JsonException;
use Psr\Http\Message\StreamInterface;

/**
 * TODO: Make it clearer that json should not be send here,
 * it will be encoded in the class.
 * Or maybe change it so json needs to be input,
 * just make it more obvious
 */
class JsonResponse extends Response
{
  public function __construct(int $statusCode, $data, int $flags = 0, int $depth = 512)
  {
    parent::__construct($statusCode);

    $this->setBody($this->createBody($data, $flags, $depth));

    $this->setHeader('Content-Type', 'application/json; charset=utf-8');
  }

  /**
   * Creates the response body from the given JSON data
   */
  private function createBody($data, int $flags, int $depth): StreamInterface
  {
    if ($data instanceof StreamInterface) {
      return $data;
    }

    try {
      $payload = json_encode($data, $flags | JSON_THROW_ON_ERROR, $depth);
    } catch (JsonException $e) {
      throw new InvalidArgumentException(sprintf(
        'Unable to create new JSON response due to invalid JSON data: %s',
        $e->getMessage()
      ), 0, $e);
    }

    return (new MessageFactory())->createStream($payload);
  }
}