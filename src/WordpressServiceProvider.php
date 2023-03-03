<?php
declare(strict_types=1);
namespace Cornatul\Wordpress;

use Cornatul\Wordpress\Interfaces\WordpressRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Cornatul\Wordpress\Repositories\WordpressRepository;
use Cornatul\Wordpress\Commands\WordpressPostCommand;

class WordpressServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'wordpress');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations', 'wordpress');
        $this->loadRoutesFrom(__DIR__.'/../routes/wordpress.php');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../database/migrations/' => \config_path('../database/migrations/'),
            ], 'wordpress-migrations');

        }
    }

    public function register(): void
    {

        $this->commands([
            WordpressPostCommand::class,
        ]);

        $this->app->bind(WordpressRepositoryInterface::class, WordpressRepository::class);
    }

}
