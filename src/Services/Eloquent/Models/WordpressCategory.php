<?php

namespace Cornatul\Wordpress\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WordpressCategory
 * @package Cornatul\Wordpress\Models
 * @property int $term_id
 */
class WordpressCategory extends Model
{
    protected $table = 'wp_terms';

    public function posts()
    {
        return $this->belongsToMany(WordpressPost::class, 'wp_term_relationships', 'term_taxonomy_id', 'object_id');
    }
}
