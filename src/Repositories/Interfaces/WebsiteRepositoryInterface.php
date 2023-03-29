<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Repositories\Interfaces;




use Cornatul\Wordpress\Models\WordpressWebsite;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface WebsiteRepositoryInterface
{
    public function createSite(array $data): WordpressWebsite;

    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function deleteSite(int $id): int;

    public function getSite(int $id): ?WordpressWebsite;
}
