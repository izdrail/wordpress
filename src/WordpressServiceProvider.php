<?php
declare(strict_types=1);
namespace Cornatul\Wordpress;

use Illuminate\Support\ServiceProvider;
use Cornatul\Wordpress\Contracts\WordpressRepositoryInterface;
use Cornatul\Wordpress\Repositories\WordpressRepository;
use Cornatul\Wordpress\Commands\WordpressPostCommand;

class WordpressServiceProvider extends ServiceProvider
{


    public function boot(): void
    {

    }

    public function register(): void
    {

        $this->commands([
            WordpressPostCommand::class,
        ]);

        $this->app->bind(WordpressRepositoryInterface::class, WordpressRepository::class);
    }

}
