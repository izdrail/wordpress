<?php

namespace Cornatul\Wordpress\WordpressRequests;
use Saloon\Enums\Method;
use Saloon\Http\Request;
class CreateTagRequest extends Request
{
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/create-tag';
    }
}
