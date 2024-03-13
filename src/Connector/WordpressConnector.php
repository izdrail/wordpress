<?php

namespace Cornatul\Wordpress\Connector;

use Cornatul\Wordpress\Repositories\WebsiteRepository;
use Saloon\Http\Connector;

class WordpressConnector extends Connector
{

    private string $base_url;

    public function __construct(string $base_url = 'https://blog.lzomedia.loc')
    {
        $this->base_url = $base_url;
    }

    public final function resolveBaseUrl(): string
    {
        return $this->base_url. '/wp-json/wp/v2/';
    }
}
