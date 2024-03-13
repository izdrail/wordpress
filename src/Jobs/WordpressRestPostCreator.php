<?php

namespace Cornatul\Wordpress\Jobs;

use Cornatul\Feeds\Models\Article;
use Cornatul\Wordpress\DTO\WordpressPostDTO;
use Cornatul\Wordpress\Repositories\Interfaces\WordpressRestInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LzoMedia\Wordpress\Models\WordpressPost;
use LzoMedia\Wordpress\Models\WordpressTaxonomies;
use LzoMedia\Wordpress\Models\WordpressTerm;
use LzoMedia\Wordpress\Objects\PostObject;

/**
 * @todo Rewrite this
 * Class CreateWordpressPost
 */
class WordpressRestPostCreator
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;

    private WordpressRestInterface $wordpressRestInterface;

    private Article $article;

    public function __construct(Article $article, WordpressRestInterface $wordpressRestInterface)
    {
        $this->article = $article;

        $this->wordpressRestInterface = $wordpressRestInterface;
    }

    final public function handle(): int
    {

        $entities = $this->article->entities;

        $categories = (json_decode($entities, true, 512, JSON_THROW_ON_ERROR));

        $categoriesToUse = collect();
        foreach ($categories as $category) {
            if ($category[3] !== 'ORDINAL' && $category[3] !== 'CARDINAL') {
                $categoriesToUse->push($category[0]);
            }
        }

        $categories = ($categoriesToUse->unique());

        $tags = json_decode($this->article->keywords, true, 512, JSON_THROW_ON_ERROR);

        $tagsToUse = collect($categories->merge($tags))->unique();

        $content = [
            'title' => $this->article->title,
            'content' => $this->article->html,
            'status' => 'publish',
            'date' => Carbon::now()->toDateTimeString(),
            'meta' => [
                'image' => $this->article->banner,
                'sentiment' => $this->article->sentiment,
                'source' => $this->article->source,

            ],
        ];

        $object = WordpressPostDTO::from($content);

        //todo rewrite this to use the wordpress rest interface
        $response = $this->wordpressRestInterface->createPost($object, 1);

        if ($response) {
            $categoryIds = [];

            $tagIds = [];

            //dispatch
            foreach ($object->categories as $category) {
                $categoryIds[] = $this->categoryService->getOrCreateCategory($category);
            }

            foreach ($object->tags as $tag) {
                $remoteTags = $this->tagService->getOrCreateTag($tag);
                if (!is_null($remoteTags)) {
                    $tagIds[] = $remoteTags;
                }
            }
            //todo dispatch the attach categories and tags
        }
        return $response;
    }
}
