<?php

namespace Cornatul\Wordpress\DTO;

use Spatie\LaravelData\Data;

class WordpressPostDTO extends Data
{
    /** @var string */
    public string $title;

    public string $status ="publish";

    /** @var string */
    public string $content;

    /** @var string */
    public string $excerpt = '';

    /** @var array */
    public array $categories;

    /** @var array */
    public array $tags;

    /** @var array */
    public ?array $meta;

}
