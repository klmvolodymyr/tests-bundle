<?php

namespace VolodymyrKlymniuk\TestsBundle\PHPUnit\Listener;

use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;
use VolodymyrKlymniuk\TestsBundle\Utils\CommandRunner;

class MigrationLauncher implements TestListener
{
    use TestListenerDefaultImplementation;

    private static $wasCalled = false;
    private array $commandOptions = [];

    public function __construct(array $commandOptions = [])
    {
        $this->commandOptions = $commandOptions;
    }

    public function startTestSuite(TestSuite $suite): void
    {
        if (!self::$wasCalled) {
            self::$wasCalled = true;

            CommandRunner::runCommand('doctrine:migrations:migrate', $this->commandOptions, MigrationsMigrateDoctrineCommand::class);
        }
    }
}