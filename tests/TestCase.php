<?php

namespace Cornatul\Wordpress\Tests;

use Cornatul\Wordpress\WordpressServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

    }

    final protected function getPackageProviders($app):array
    {
        $app->register(WordpressServiceProvider::class);
        return [
            WordpressServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // perform environment setup
    }
}
