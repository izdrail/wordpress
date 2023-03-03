<?php

namespace Cornatul\Wordpress\Repositories;

use Corcel\Model\Post;
use Cornatul\Wordpress\Interfaces\WordpressRepositoryInterface;
use Cornatul\Wordpress\Models\WordpressPost;
use Cornatul\Wordpress\Models\WordpressTermRelationship;
use Cornatul\Wordpress\Models\WordpressWebsite;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use LzoMedia\Wordpress\Models\WordpressTerm;

class WordpressRepository implements WordpressRepositoryInterface
{
    public function createSite(array $data): WordpressWebsite
    {
        return WordpressWebsite::create($data);
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return WordpressWebsite::paginate($perPage);
    }

    public function deleteSite(int $id): int
    {
       return  WordpressWebsite::destroy($id);
    }

    public function createPost(string $title, string $content, array $categoryNames = [], array $tagNames = []): int
    {
        $post = new Post();
        $post->post_title = $title;
        $post->post_content = $content;
        $post->post_type = 'post';
        $post->post_status = 'publish';
        $post->save();

        $postId = $post->ID;

        foreach ($categoryNames as $categoryName) {
            $term = WordpressTerm::where('name', $categoryName)->where('taxonomy', 'category')->first();

            if (!$term) {
                $term = new WordpressTerm([
                    'name' => $categoryName,
                    'slug' => sanitize_title($categoryName),
                    'taxonomy' => 'category',
                ]);
                $term->save();
            }

            $termRelationship = new WordpressTermRelationship([
                'object_id' => $postId,
                'term_taxonomy_id' => $term->term_id,
            ]);
            $termRelationship->save();
        }

        foreach ($tagNames as $tagName) {
            $term = WordpressTerm::where('name', $tagName)->where('taxonomy', 'post_tag')->first();

            if (!$term) {
                $term = new WordpressTerm([
                    'name' => $tagName,
                    'slug' => sanitize_title($tagName),
                    'taxonomy' => 'post_tag',
                ]);
                $term->save();
            }

            $termRelationship = new TermRelationship([
                'object_id' => $postId,
                'term_taxonomy_id' => $term->term_id,
            ]);
            $termRelationship->save();
        }

        return $postId;
    }
}
