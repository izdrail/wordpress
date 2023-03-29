<?php
declare(strict_types=1);
namespace Cornatul\Wordpress;


use Cornatul\Wordpress\Repositories\Interfaces\WebsiteRepositoryInterface;
use Cornatul\Wordpress\Repositories\Interfaces\WordpressRestInterface;
use Cornatul\Wordpress\Repositories\WebsiteRepository;
use Cornatul\Wordpress\Services\Rest\WordpressPostRestService;
use Illuminate\Support\ServiceProvider;
use Cornatul\Wordpress\Commands\WordpressPostCommand;

class WordpressServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'wordpress');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
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

        $this->app->bind(WebsiteRepositoryInterface::class, WebsiteRepository::class);
        $this->app->bind(WordpressRestInterface::class, WordpressPostRestService::class);
    }

}
