<?php

namespace Cornatul\Wordpress\WordpressRequests;
use Cornatul\Wordpress\DTO\WordpressPostDTO;
use Saloon\Enums\Method;
use Saloon\Http\Request;
class CreatePostRequest extends Request
{
    protected Method $method = Method::POST;

    protected WordpressPostDTO $postDTO;

    public function __construct(WordpressPostDTO $postDTO)
    {
        $this->postDTO = $postDTO;
    }

    public function resolveEndpoint(): string
    {
        return '/posts';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
