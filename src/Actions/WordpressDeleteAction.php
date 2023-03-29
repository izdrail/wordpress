<?php

namespace Cornatul\Wordpress\Actions;

use Cornatul\Wordpress\Repositories\WebsiteRepository;
use Illuminate\Http\Request;

class WordpressDeleteAction
{
    private WebsiteRepository $websiteRepository;

    public function __construct(WebsiteRepository $websiteRepository)
    {
        $this->websiteRepository = $websiteRepository;
    }
    public function handle(int $siteId):int
    {
        return $this->websiteRepository->deleteSite($siteId);
    }

}
