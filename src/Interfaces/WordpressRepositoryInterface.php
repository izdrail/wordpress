<?php
declare(strict_types=1);

namespace Cornatul\Wordpress\Interfaces;




use Cornatul\Wordpress\Models\WordpressWebsite;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface WordpressRepositoryInterface
{
    public function createSite(array $data): WordpressWebsite;

    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function deleteSite(int $id): int;

    public function createPost(string $title, string $content, array $categories, array $tags): int;
}
