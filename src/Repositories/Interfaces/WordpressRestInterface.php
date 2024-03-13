<?php

namespace Cornatul\Wordpress\Repositories\Interfaces;

use Cornatul\Wordpress\DTO\WordpressPostDTO;

interface WordpressRestInterface
{
    public function createPost(WordpressPostDTO $data, int $siteID): int;
}
