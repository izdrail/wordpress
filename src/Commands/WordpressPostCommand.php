<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Commands;

use Carbon\Carbon;

use Cornatul\Wordpress\DTO\WordpressPostDTO;

use Cornatul\Wordpress\Repositories\Interfaces\WordpressRestInterface;
use Cornatul\Wordpress\Services\Rest\WordpressPostRestService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class WordpressPostCommand extends Command
{
    protected $signature = 'wordpress:post';

    protected $description = 'This command will post a selected article to wordpress';


    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function handle(WordpressPostRestService $postRestService): void
    {
        $content = [
            'title' => 'Other Test Post 7',
            'content' => 'Test',
            'status' => 'publish',
            'date' => Carbon::now()->toDateTimeString(),
            'categories' => [
                'coding',
                'work',
                'development',
            ],
            'tags' => [
                'development',
                'services',
                'php',
            ],
            'meta' => [
                'image' => '',
            ],
        ];


        $object = WordpressPostDTO::from($content);

        $response = $postRestService->createPost($object, 1);

        $this->info($response);
    }
}
