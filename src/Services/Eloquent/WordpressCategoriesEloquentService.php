<?php

namespace Cornatul\Wordpress\Services\Eloquent;

use Cornatul\Wordpress\Models\WordpressCategory;

class WordpressCategoriesEloquentService
{

    public WordpressCategory $category;

    public function __construct(WordpressCategory $category)
    {
        $this->category = $category;
    }

    public function createCategory(array $data): bool
    {
        return $this->category->create($data)->exists;
    }

}
