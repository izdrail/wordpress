<?php

namespace Cornatul\Wordpress\Clients;

use Cornatul\Feeds\Connectors\NlpConnector;
use Cornatul\Feeds\DTO\ArticleDto;
use Cornatul\Feeds\Requests\GetArticleRequest;
use Cornatul\News\Connectors\NewsApiConnector;
use Cornatul\News\Connectors\TrendingKeywordsConnector;
use Cornatul\News\Connectors\TrendingNewsConnector;
use Cornatul\News\DTO\NewsArticleDto;
use Cornatul\News\DTO\NewsDTO;
use Cornatul\News\Interfaces\NewsInterface;
use Cornatul\News\Interfaces\TrendingInterface;
use Cornatul\News\Interfaces\TwitterInterface;
use Cornatul\News\Requests\AllNewsRequest;
use Cornatul\News\Requests\HeadlinesRequest;
use Cornatul\News\Requests\TrendingKeywordsRequest;
use Cornatul\News\Requests\TrendingNewsRequest;
use Cornatul\Social\DTO\TwitterTrendingDTO;
use Cornatul\Wordpress\Connector\WordpressConnector;
use Cornatul\Wordpress\DTO\WordpressPostDTO;
use Cornatul\Wordpress\Repositories\WebsiteRepository;
use Cornatul\Wordpress\WordpressRequests\CreatePostRequest;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;

/**
 * todo move this to a job
 */
class WordpressRestClient
{
    private int $site_id;
    public function __construct(int $siteID  = 1)
    {
        $this->site_id = $siteID;
    }

    public function handle(): void
    {
        $websiteRepository = new WebsiteRepository();
        $website = $websiteRepository->getSite($this->site_id);

        $connector = new WordpressConnector($website->database_host);

        $connector->withBasicAuth($website->database_user, $website->database_pass);

        //todo move te categories and tags to a new request
        $postDTO = WordpressPostDTO::from([
            'title' => 'Test Post',
            'content' => 'Test Content',
            'status' => 'publish',
            'categories' => [1],
            'tags' => [1],
        ]);

        $response = $connector->send(new CreatePostRequest($postDTO));

        dd($response);
    }

}
