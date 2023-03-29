<?php

namespace Cornatul\Wordpress\Actions;

use Cornatul\Wordpress\Interfaces\WordpressRepositoryInterface;
use Cornatul\Wordpress\Repositories\WebsiteRepository;
use Illuminate\Http\Request;

class WordpressStoreAction
{
    private Request $request;

    private WebsiteRepository $wordpressRepository;

    public function __construct(Request $request, WebsiteRepository $wordpressRepository)
    {
        $this->request = $request;
        $this->wordpressRepository = $wordpressRepository;
    }

    public function handle()
    {
        $this->request->validate([
            'name' => 'required',
            'database_host' => 'required',
            'database_user' => 'required',
            'database_pass' => 'nullable',
            'database_name' => 'required',
        ]);

        return $this->wordpressRepository->createSite($this->request->all());
    }

}
