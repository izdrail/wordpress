<?php

namespace Cornatul\Wordpress\Repositories;

use Cornatul\Wordpress\DTO\WordpressPostDTO;
use Cornatul\Wordpress\Repositories\Interfaces\WordpressRestInterface;
use Cornatul\Wordpress\Services\Rest\WordpressPostRestService;

class WordpressRestRepository implements WordpressRestInterface
{

    public WordpressPostRestService $postRestService;

    public function __construct(WordpressPostRestService $postRestService)
    {
        $this->postRestService = $postRestService;
    }

    public function createPost(WordpressPostDTO $data): bool
    {
        return $this->postRestService->createPost($data);
    }
}
