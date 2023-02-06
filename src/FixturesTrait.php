<?php

//namespace VolodymyrKlymniuk\TestsBundle;

trait FixturesTrait
{
    public function load(array $files, $append = false)
    {
        $fixtureFiles = [];

        foreach ($files as $file) {
            $fixtureFiles[] = $this->doLocateFiles($file);
        }
        $loader = $this->getContainer()->get('fidry_alice_data_fixtures.loader.doctrine_mongodb');

        return $loader->load($fixtureFiles);
    }

    protected function doLocateFiles(string $path): string
    {
        $path = sprintf('%s/%s', 'tests/DataFixtures', $path);
        $path = realpath($path);

        if (false === $path || false === file_exists($path)) {
            throw new \LogicException(sprintf("File %s does not exist", $path));
        }

        return $path;
    }
}