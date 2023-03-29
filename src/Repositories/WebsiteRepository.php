<?php

namespace Cornatul\Wordpress\Repositories;

use Corcel\Model\Post;
use Cornatul\Wordpress\Interfaces\WordpressRepositoryInterface;
use Cornatul\Wordpress\Models\WordpressPost;
use Cornatul\Wordpress\Models\WordpressTermRelationship;
use Cornatul\Wordpress\Models\WordpressWebsite;
use Cornatul\Wordpress\Repositories\Interfaces\WebsiteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Cornatul\Wordpress\Models\WordpressTerm;

class WebsiteRepository implements WebsiteRepositoryInterface
{
    public function createSite(array $data): WordpressWebsite
    {
        return WordpressWebsite::create($data);
    }

    public function deleteSite(int $id): int
    {
        return  WordpressWebsite::destroy($id);
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return WordpressWebsite::paginate($perPage);
    }

    public function getSite(int $id): ?WordpressWebsite
    {
        return WordpressWebsite::find($id);
    }
}
