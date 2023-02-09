<?php

namespace VolodymyrKlymniuk\TestsBundle\PHPUnit\Listener;

use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;
use VolodymyrKlymniuk\SfFunctionalTest\Command\FixturesLoadTruncateCommand;
use VolodymyrKlymniuk\TestsBundle\Utils\CommandRunner;

class FixtureLoader implements TestListener
{
    use TestListenerDefaultImplementation;

    /**
     * @var bool
     */
    private static $wasCalled = false;
    /**
     * @var array
     */
    private $commandOptions = [];

    /**
     * FixtureLoader constructor.
     *
     * @param array $commandOptions
     */
    public function __construct(array $commandOptions = [])
    {
        $this->commandOptions = $commandOptions;
    }

    /**
     * @param TestSuite $suite
     */
    public function startTestSuite(TestSuite $suite): void
    {
        if (!self::$wasCalled) {
            self::$wasCalled = true;

            CommandRunner::runCommand("functional-test:fixtures:load", $this->commandOptions, FixturesLoadTruncateCommand::class);
            //  CommandRunner::runCommand(FixturesLoadTruncateCommand::NAME, $this->commandOptions, FixturesLoadTruncateCommand::class);
        }
    }
}