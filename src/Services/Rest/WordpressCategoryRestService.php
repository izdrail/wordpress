<?php

namespace Cornatul\Wordpress\Services\Rest;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;

class WordpressCategoryRestService
{
    private Client $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getCategory(string $categoryName):?int
    {
        $response = $this->client->get("v2/categories?search={$categoryName}", [
            'json' => [
                'name' => $categoryName
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            $category = json_decode(
                $response->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            if (!empty($category)) {
                return $category[0]['id'];
            }
        }
        return null;
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    private function createCategory(string $category_name): ?int
    {
        $data = [
            'name' => $category_name,
            'slug' => Str::slug($category_name),
        ];
        $response = $this->client->post('v2/categories', [
            'json' => $data,
        ]);

        if ($response->getStatusCode() === 201) {
            $category = json_decode(
                $response->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
            return $category['id'];
        }

        return null;
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getOrCreateCategory(string $categoryName):int
    {
        $category_id = $this->getCategory($categoryName);

        if ($category_id) {
            return $category_id;
        }

        return $this->createCategory($categoryName);
    }
}
