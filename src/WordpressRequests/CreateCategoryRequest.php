<?php

namespace Cornatul\Wordpress\WordpressRequests;
use Saloon\Enums\Method;
use Saloon\Http\Request;
class CreateCategoryRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/create-post';
    }
}
