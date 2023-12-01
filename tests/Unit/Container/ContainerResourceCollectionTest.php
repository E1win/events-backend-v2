<?php
namespace Tests\Unit\Container;

use Framework\Container\Exception\ContainerException;
use Framework\Container\Resource\ContainerResource;
use Framework\Container\Resource\ContainerResourceCollection;
use Framework\Container\Resource\ContainerAutowirer;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Container\MockClass\ClassWithDependency;
use Tests\Unit\Container\MockClass\ClassWithInterfaceDependency;
use Tests\Unit\Container\MockClass\ClassWithPrimitiveParameter;
use Tests\Unit\Container\MockClass\MockInterface;

class ContainerResourceCollectionTest extends TestCase
{
  private ContainerResourceCollection $resourceCollection;

  protected function setUp(): void
  {
    parent::setUp();

    $this->resourceCollection = new ContainerResourceCollection(
      [],
      (new ContainerAutowirer())
    );
  }

  /** @test */
  public function it_registers_a_resource(): void
  {
    $this->resourceCollection->addResources([
      ClassWithPrimitiveParameter::class => [
        4
      ],
    ]);

    $expected = [
      ClassWithPrimitiveParameter::class => [
        4
      ]
    ];

    $this->assertSame($expected, $this->resourceCollection->getResources());
  }

  /** @test */
  public function it_gets_unprocessed_resource(): void
  {
    $this->resourceCollection->addResources(
      $this->dependencyConfiguration()
    );

    $expected = new ContainerResource(
      ClassWithPrimitiveParameter::class,
      [4]
    );

    $resource = $this->resourceCollection
      ->getResource(ClassWithPrimitiveParameter::class);

    $this->assertSame(
      $expected->getName(),
      $resource->getName(),
    );

    $this->assertSame(
      $expected->getParameters(),
      $resource->getParameters()
    );
  }

  /** @test */
  public function it_throws_container_exception_for_unknown_parameters()
  {
    $this->expectException(ContainerException::class);

    $this->resourceCollection->getResource(ClassWithPrimitiveParameter::class);
  }

  /** @test */
  public function it_automatically_resolves_dependencies()
  {
    $this->resourceCollection->addResources(
      $this->dependencyConfiguration()
    );

    $expected = new ContainerResource(
      ClassWithDependency::class,
      [
        (new ContainerResource(
          ClassWithPrimitiveParameter::class,
          [4]
        ))
      ]
    );

    $resource = $this->resourceCollection
      ->getResource(ClassWithDependency::class);

    $this->assertSame(
      $expected->getName(),
      $resource->getName(),
    );


    $this->assertSame(
      $expected->getParameters()[0]->getName(),
      $resource->getParameters()[0]->getName()
    );
  }

  public function dependencyConfiguration(): array
  {
    return [
      ClassWithPrimitiveParameter::class => [4],
    ];
  }

  /** @test */
  public function it_resolves_aliases()
  {
    $this->resourceCollection->addResources(
      $this->dependencyConfiguration()
    );

    $this->resourceCollection->addAlias(
      MockInterface::class,
      ClassWithPrimitiveParameter::class
    );

    $expected = new ContainerResource(
      ClassWithInterfaceDependency::class,
      [
        (new ContainerResource(
          ClassWithPrimitiveParameter::class,
          [4]
        ))
      ]
    );

    $resource = $this->resourceCollection
      ->getResource(ClassWithInterfaceDependency::class);

    $this->assertSame(
      $expected->getParameters()[0]->getName(),
      $resource->getParameters()[0]->getName()
    );
  }

  // Write test to see if caching resources works.
}