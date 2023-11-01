<?php

namespace Cornatul\Wordpress\WordpressRequests;
use Illuminate\Support\Str;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateCategoryRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected string  $category)
    {
    }

    public final function resolveEndpoint(): string
    {
        return '/categories';
    }

    protected function defaultBody(): array
    {
        return [
            'name' => $this->category,
            'description' =>  $this->category,
            'slug' => Str::slug($this->category),
            'parent' => 0,
            'meta' => [],
        ];
    }
}
