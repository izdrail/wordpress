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
use Cornatul\Wordpress\Repositories\WebsiteRepository;
use Cornatul\Wordpress\WordpressRequests\CreatePostRequest;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;

class WordpressEloquentClient
{
    private int $site_id;
    public function __construct(int $siteID  = 1)
    {
        $this->site_id = $siteID;
    }

    public function handle(): void
    {
        $connector = new WordpressConnector($this->site_id);
        $request= $connector->get(new CreatePostRequest());
        dd($connector);
    }

}
