<?php

namespace Cornatul\Wordpress\DTO;

use Spatie\LaravelData\Data;

class WordpressPostDTO extends Data
{
    /** @var string */
    public string $title;

    /** @var string */
    public string $content;

    /** @var string */
    public array $categories;

    /** @var array */
    public array $tags;

    public ?array $meta;
}
