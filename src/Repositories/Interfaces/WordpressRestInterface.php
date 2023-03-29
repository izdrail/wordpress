<?php

namespace Cornatul\Wordpress\Repositories\Interfaces;

use Cornatul\Wordpress\DTO\WordpressPostDTO;

interface WordpressRestInterface
{
    /**
     * @param WordpressPostDTO $data
     * @return int
     */
    public function createPost(WordpressPostDTO $data, int $siteID): int;
}
