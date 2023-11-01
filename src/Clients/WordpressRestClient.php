<?php

namespace Cornatul\Wordpress\Clients;

use Cornatul\Feeds\Connectors\NlpConnector;
use Cornatul\Feeds\DTO\ArticleDto;
use Cornatul\Feeds\Models\Article;
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
use Cornatul\Wordpress\WordpressRequests\CreateCategoryRequest;
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
    /**
     * @todo the siteID should be a repository output class
     * @param Article $article
     * @param int $siteID
     */
    public function __construct(protected  Article $article, protected int $siteID  = 1)
    {
        $this->site_id = $siteID;
        $this->article = $article;
    }

    /**
     * todo move the logic of the website outside the client and pass it as a parameter
     * @throws \ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public final function handle(): void
    {
        $websiteRepository = new WebsiteRepository();

        $website = $websiteRepository->getSite($this->site_id);

        $connector = new WordpressConnector($website->database_host);

        $connector->withBasicAuth($website->database_user, $website->database_pass);

        $category = collect($this->article->keywords)->first();
        $tags = collect($this->article->keywords)->slice(1, 5)->toArray();
        $postDTO = WordpressPostDTO::from([
            'title' => $this->article->title,
            'content' => $this->article->spacy,
            'status' => 'publish',
            'categories' => [
                $this->getOrCreateCategories($category),
            ],
            'tags' => [
                $this->getOrCreateTags($tags),
            ],
        ]);

        $connector->send(new CreatePostRequest($postDTO));
    }


    /**
     * @throws InvalidResponseClassException
     * @throws \ReflectionException
     * @throws PendingRequestException
     * @throws \Exception
     */
    private function getOrCreateCategories(string $category): int
    {
        $websiteRepository = new WebsiteRepository();

        $website = $websiteRepository->getSite($this->site_id);

        $connector = new WordpressConnector($website->database_host);

        $connector->withBasicAuth($website->database_user, $website->database_pass);

        $categoryRequest = $connector->send(new CreateCategoryRequest($category));
        $code = ($categoryRequest->collect('code')->first());
        if ($code === 'term_exists') {
            return $categoryRequest->collect('data')->collect('term_id')->toArray()['term_id'];
        }

        dd($categoryRequest->collect('data'));
    }

    private function getOrCreateTags(array $tags): array
    {
        //todo dispatch dhis to a job
        return [];
    }

}
