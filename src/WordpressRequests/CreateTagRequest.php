<?php

namespace Cornatul\Wordpress\WordpressRequests;
use Illuminate\Support\Str;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;


class CreateTagRequest extends Request implements HasBody
{
    protected Method $method = Method::POST;

    use HasJsonBody;

    public function __construct(protected string  $tag)
    {
    }

    public final function resolveEndpoint(): string
    {
        return '/tags';
    }

    protected function defaultBody(): array
    {
        return [
            'name' => $this->tag,
            'description' =>  $this->tag,
            'slug' => Str::slug($this->tag),
            'meta' => [],
        ];
    }
}
