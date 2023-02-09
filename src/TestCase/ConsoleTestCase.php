<?php

namespace VolodymyrKlymniuk\TestsBundle\TestCase;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use VolodymyrKlymniuk\SfFunctionalTest\TestCase\AppTestCase;

class ConsoleTestCase extends AppTestCase
{
    public static function runConsoleCommand(string $name, array $options = [], Application $consoleApp = null): int
    {
        $consoleApp = is_null($consoleApp) ? self::createConsoleApp() : $consoleApp;
        $options['-e'] = isset($options['-e']) ? $options['-e'] : 'test';
        $options['-q'] = null;
        $options = array_merge($options, ['command' => $name]);
        $result = $consoleApp->run(new ArrayInput($options), new ConsoleOutput());

        $consoleApp->getKernel()->shutdown();

        return $result;
    }

    public static function createConsoleApp(array $kernelOptions = [], bool $autoExit = false): Application
    {
        $kernel = static::createKernel($kernelOptions);
        $kernel->boot();
        $consoleApp = new Application($kernel);
        $consoleApp->setAutoExit($autoExit);

        return $consoleApp;
    }
}