<?php

namespace Cornatul\Wordpress\Repositories;

use Cornatul\Wordpress\Interfaces\WordpressRestInterface;
use LzoMedia\Wordpress\Services\WordpressPostRestService;
use LzoMedia\Wordpress\Services\WordpressCategoryRestService;
use LzoMedia\Wordpress\Services\WordpressTagRestService;

class WordpressEloquentRepository implements WordpressEloquentInterface
{



    public function createPost(array $data): bool
    {
        return $this->postRestService->getOrCreatePost(
            $data['title'],
            $data['content'],
            $data['categories'],
            $data['tags']
        );
    }
}
