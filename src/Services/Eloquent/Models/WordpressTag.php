<?php

namespace Cornatul\Wordpress\Models;


class WordpressTag extends Model
{
    protected $table = 'wp_terms';

    public function posts()
    {
        return $this->belongsToMany(WordpressPost::class, 'wp_term_relationships', 'term_taxonomy_id', 'object_id');
    }
}
