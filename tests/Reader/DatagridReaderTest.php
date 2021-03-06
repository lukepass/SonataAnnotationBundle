<?php

declare(strict_types=1);

namespace KunicMarko\SonataAnnotationBundle\Tests\Reader;

use Doctrine\Common\Annotations\AnnotationReader;
use KunicMarko\SonataAnnotationBundle\Reader\DatagridReader;
use KunicMarko\SonataAnnotationBundle\Tests\Fixtures\AnnotationClass;
use KunicMarko\SonataAnnotationBundle\Tests\Fixtures\AnnotationExceptionClass;
use KunicMarko\SonataAnnotationBundle\Tests\Fixtures\EmptyClass;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class DatagridReaderTest extends TestCase
{
    /**
     * @var DatagridReader
     */
    private $datagridReader;
    private $datagridMapper;

    protected function setUp(): void
    {
        $this->datagridMapper = $this->prophesize(DatagridMapper::class);
        $this->datagridReader = new DatagridReader(new AnnotationReader());
    }

    public function testConfigureFieldsNoAnnotation(): void
    {
        $this->datagridMapper->add()->shouldNotBeCalled();
        $this->datagridReader->configureFields(
            new \ReflectionClass(EmptyClass::class),
            $this->datagridMapper->reveal()
        );
    }

    public function testConfigureFieldsAnnotationPresent(): void
    {
        $this->datagridMapper->add('field', Argument::cetera())->shouldBeCalled();
        $this->datagridMapper->add('parent.name', Argument::cetera())->shouldBeCalled();

        $this->datagridReader->configureFields(
            new \ReflectionClass(AnnotationClass::class),
            $this->datagridMapper->reveal()
        );
    }

    /**
     * @group legacy
     * @expectedDeprecation The "KunicMarko\SonataAnnotationBundle\Annotation\ParentAssociationMapping" annotation is deprecated since 1.1, to be removed in 2.0. Use KunicMarko\SonataAnnotationBundle\Annotation\AddChild instead.
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Argument "field" is mandatory in "KunicMarko\SonataAnnotationBundle\Annotation\DatagridAssociationField" annotation.
     */
    public function testConfigureFieldsAnnotationException(): void
    {
        $this->datagridReader->configureFields(
            new \ReflectionClass(AnnotationExceptionClass::class),
            $this->datagridMapper->reveal()
        );
    }
}
