<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Commands;


use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;


class WordpressPostCommand extends Command
{
    protected $signature = 'wordpress:post {article_id}';

    protected $description = 'This command will post a selected article to wordpress';


    public function handle(WordpressRepositoryInterface $wordpressRepository): void
    {

    }
}
