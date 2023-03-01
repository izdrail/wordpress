<?php

namespace LzoMedia\Wordpress\Services;

use App\Contracts\ArticleContract;
use App\Models\Article;
use Exception;
use Illuminate\Support\Facades\Log;
use LzoMedia\Wordpress\Contracts\WordpressContract;
use LzoMedia\Wordpress\Jobs\CreateWordpressPost;

class WordpressService implements WordpressContract
{


    public function articleExists(Article $article): bool
    {
        return true;
    }

    public function createArticle(Article $article): void
    {
        dispatch(new CreateWordpressPost($article));
    }
}
