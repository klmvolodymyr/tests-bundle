<?php
namespace VolodymyrKlymniuk\TestsBundle\Utils;

use VolodymyrKlymniuk\TestsBundle\TestCase\ConsoleTestCase;

class CommandRunner
{
    public static function runCommand(string $name, array $options, string $class)
    {
        $consoleApp = ConsoleTestCase::createConsoleApp();
        if (!$consoleApp->has($name)) {
            $consoleApp->add(new $class($name));
        }
        ConsoleTestCase::runConsoleCommand($name, $options, $consoleApp);
    }
}