<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Commands;


use Carbon\Carbon;
use Cornatul\Feeds\Interfaces\ArticleRepositoryInterface;
use Cornatul\Wordpress\Interfaces\WordpressRepositoryInterface;
use Exception;
use Illuminate\Console\Command;


class WordpressPostCommand extends Command
{
    protected $signature = 'wordpress:post {article_id}';

    protected $description = 'This command will post a selected article to wordpress';


    public function handle(WordpressRepositoryInterface $wordpressRepository, ArticleRepositoryInterface $repository): void
    {
        $article = $repository->getArticleById(2);

        $wordpressRepository->createPost($article->title, $article->markdown, ["Category 1", "Category 2"], json_decode($article->keywords));

        $article = $wordpressRepository->find($this->argument('article_id'));
    }
}
