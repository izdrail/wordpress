<?php

namespace Cornatul\Wordpress\Repositories\Interfaces;

interface WordpressEloquentInterface
{

    public function createPost(array $data): bool;

    public function createCategory(array $data): bool;

}
