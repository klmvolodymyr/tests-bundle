<?php

namespace VolodymyrKlymniuk\TestsBundle\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as BaseKernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use VolodymyrKlymniuk\TestsBundle\FixturesTrait;

abstract class KernelTestCase extends BaseKernelTestCase
{
    use FixturesTrait;

    protected static function getContainer(array $options = []): ContainerInterface
    {
        $kernel = static::bootKernel($options);

        return $kernel->getContainer();
    }
}