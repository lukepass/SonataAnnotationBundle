<?php

declare(strict_types=1);

namespace KunicMarko\SonataAnnotationBundle\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 *
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class ListAction implements AnnotationInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $options = [];

    public function getName(): string
    {
        if ($this->name) {
            return $this->name;
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Argument "name" is mandatory in "%s" annotation.',
                self::class
            )
        );
    }
}
