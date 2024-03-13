<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Services\Rest;

use Cornatul\Wordpress\DTO\WordpressPostDTO;
use Cornatul\Wordpress\Models\WordpressCategory;
use Cornatul\Wordpress\Repositories\Interfaces\WebsiteRepositoryInterface;
use Cornatul\Wordpress\Repositories\Interfaces\WordpressRestInterface;
use Cornatul\Wordpress\Repositories\WebsiteRepository;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class WordpressPostRestService implements WordpressRestInterface
{

    private WebsiteRepositoryInterface $websiteRepository;

    private WordpressCategoryRestService $categoryService;

    private WordpressTagRestService $tagService;

    private Client $client;

    public function __construct(WebsiteRepositoryInterface $websiteRepository)
    {
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @throws \JsonException
     * @throws GuzzleException
     * @throws \Exception
     */
    public function createPost(WordpressPostDTO $data, int $siteID): int
    {
        $client = $this->buildWordpressClient($siteID);

//        $postId = $this->getPost($data->title);
//
//        if ($postId) {
//            return $postId;
//        }


        $content = [
            'title' => $data->title,
            'content' => $data->content,
            'status' => 'publish',
            'meta_input' => $data->meta,
        ];

        $response = $client->post('v2/posts', [
            'json' => $content,
        ]);

        if ($response->getStatusCode() === 201) {
            $post = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            return $post['id'];
        }

        return 1;
    }

    /**
     * Get the ID of a post by title
     *
     * @param string $title The title of the post
     *
     * @return int|null The ID of the post or null if not found
     * @throws \JsonException
     */
    public function getPost(string $title): ?int
    {
        $response = $this->client->get('v2/search', [
            'query' => [
                'search' => $title,
                'per_page' => 1,
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            $posts = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            if (!empty($posts)) {
                return $posts[0]['id'];
            }
            return null;
        }
        return null;
    }


    /**
     * @method private buildWordpressClient
     * @throws \Exception
     */
    private function buildWordpressClient(int $siteID): Client
    {
        $website = $this->websiteRepository->getSite($siteID);

        if (!$website) {
            throw new \RuntimeException('Website not found');
        }

        return new Client([
            'base_uri'        => $website->database_host,
            'timeout'         => 0,
            'allow_redirects' => true,
            'headers'         => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(
                    $website->database_user . ':' . $website->database_pass
                ),
            ],
        ]);

        //$this->categoryService = new WordpressCategoryRestService($this->client);

        //$this->tagService = new WordpressTagRestService($this->client);
    }
}
