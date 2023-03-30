<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Services\Rest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use JsonException;

class WordpressTagRestService
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    private function getTag(string $tag_name):?int
    {
        $response = $this->client->get('v2/tags?search='.$tag_name, [
            'query' => ['slug' => $tag_name],
        ]);

        if ($response->getStatusCode() === 200) {
            $tag = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            if (!empty($tag)) {
                return $tag[0]['id'];
            }
        }
        return null;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    private function createTag(string $tag_name):?int
    {
        try {
            $data = [
                'name' => $tag_name,
                'slug' => Str::slug($tag_name),
            ];

            $response = $this->client->post('v2/tags', [
                'json' => $data,
            ]);

            if ($response->getStatusCode() === 400) {
               return null;
            }

            if ($response->getStatusCode() === 201) {
                $tag = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

                return $tag['id'];
            }
        } catch (ClientException $e) {
            return null;
        }
        return null;
    }

    /**
     * @throws JsonException
     * @throws GuzzleException
     */
    public function getOrCreateTag(string $tag_name):?int
    {
        $tag_id = $this->getTag($tag_name);

        logger()->info('Tag ID: ' . $tag_id);
        if ($tag_id) {
            return $tag_id;
        }

        return $this->createTag($tag_name);
    }
}
