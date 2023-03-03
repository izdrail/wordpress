<?php

namespace Cornatul\Wordpress\DTO;

use Spatie\LaravelData\Data;

class WordpressPostDto extends Data
{
    /** @var string */
    public string $title;

    /** @var string */
    public string $content;

    /** @var array */
    public array $categories;

    /** @var array */
    public array $tags;
}
