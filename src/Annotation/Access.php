<?php

declare(strict_types=1);

namespace KunicMarko\SonataAnnotationBundle\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 *
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class Access implements AnnotationInterface
{
    /**
     * @var string
     */
    public $role;

    /**
     * @var array
     */
    public $permissions;
}