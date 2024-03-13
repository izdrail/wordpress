<?php

namespace Cornatul\Wordpress\Jobs;

use Cornatul\Wordpress\DTO\WordpressPostDTO;
use GuzzleHttp\ClientInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AttachCategoriesPostRest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public WordpressPostDTO $data;

    public ClientInterface $client;

    public function __construct(WordpressPostDTO $data, ClientInterface $client)
    {
        $this->data = $data;
        $this->client = $client;
    }

    public function handle(): void
    {
    }
}
