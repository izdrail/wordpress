<?php

namespace Cornatul\Wordpress\Interfaces;



use Cornatul\Feeds\Models\Article;

interface WordpressRepositoryInterface
{
    public function createPost(Article $article): void;

}
