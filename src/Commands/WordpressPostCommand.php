<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Commands;

use Carbon\Carbon;

use Cornatul\Feeds\Models\Article;
use Cornatul\Wordpress\DTO\WordpressPostDTO;

use Cornatul\Wordpress\Jobs\WordpressRestPostCreator;
use Cornatul\Wordpress\Repositories\Interfaces\WordpressRestInterface;
use Cornatul\Wordpress\Services\Rest\WordpressPostRestService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class WordpressPostCommand extends Command
{
    protected $signature = 'wordpress:post';

    protected $description = 'This command will post a selected article to wordpress';


    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function handle(WordpressPostRestService $postRestService): void
    {

        $articles = Article::all();

        foreach ($articles as $article) {
            if (str_word_count($article->text) > 500) {
                dispatch(new WordpressRestPostCreator($article, $postRestService))->onQueue('wordpress_publish');
            }

            $this->info('Article ' . $article->id . ' was skipped publishing');
        }
    }
}
