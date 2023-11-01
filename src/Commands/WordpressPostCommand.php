<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Commands;

use Carbon\Carbon;

use Cornatul\Feeds\Models\Article;
use Cornatul\Wordpress\Clients\WordpressRestClient;
use Cornatul\Wordpress\DTO\WordpressPostDTO;

use Cornatul\Wordpress\Jobs\WordpressRestPostCreator;
use Cornatul\Wordpress\Repositories\Interfaces\WordpressRestInterface;
use Cornatul\Wordpress\Services\Rest\WordpressPostRestService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class WordpressPostCommand extends Command
{
    protected $signature = 'wordpress:post';

    protected $description = 'This command will post a selected article to wordpress';

    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function handle(WordpressPostRestService $postRestService): void
    {

        $articles = Article::all();

        foreach ($articles as $article) {

            $client = new WordpressRestClient($article,1);;
            $response = $client->handle();

        }
    }
}
