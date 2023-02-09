<?php

namespace VolodymyrKlymniuk\TestsBundle\PHPUnit\Listener;

use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use Symfony\Component\Dotenv\Dotenv;
use PHPUnit\Framework\TestSuite;

class EnvLoader implements TestListener
{
    use TestListenerDefaultImplementation;

    /**
     * @var bool
     */
    private static $wasCalled = false;
    /**
     * @var array
     */
    private $paths = [];

    /**
     * EnvLoader constructor.
     *
     * @param array $paths
     */
    public function __construct(array $paths = [])
    {
        $this->paths = $paths;
    }

    /**
     * @param TestSuite $suite
     */
    public function startTestSuite(TestSuite $suite): void
    {
        if (!self::$wasCalled) {
            self::$wasCalled = true;

            $dir = isset($GLOBALS['__PHPUNIT_CONFIGURATION_FILE']) ? dirname($GLOBALS['__PHPUNIT_CONFIGURATION_FILE']) : '';
            $paths = array_map(
                function (string $path) use ($dir) {
                    return realpath($dir . DIRECTORY_SEPARATOR . $path);
                },
                $this->paths
            );
            (new Dotenv())->load(...$paths);
        }
    }
}