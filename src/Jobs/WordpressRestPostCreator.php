<?php

namespace Cornatul\Wordpress\Jobs;



use App\Models\Article;
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
class WordpressRestPostCreator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public WordpressPostDTO $postObject;
    private WordpressRestInterface $wordpressRestInterface;

    public function __construct(WordpressPostDTO $postObject, WordpressRestInterface $wordpressRestInterface)
    {
        $this->postObject = $postObject;
        $this->wordpressRestInterface = $wordpressRestInterface;
    }

    final public function handle(): void
    {
        try {
            $this->wordpressRestInterface->createPost($this->postObject);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
