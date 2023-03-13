<?php

namespace Cornatul\Wordpress\Models;

class WordpressTermTaxonomy
{
    protected $table = 'wp_term_taxonomy';

    public function term()
    {
        return $this->belongsTo(WordpressTerm::class, 'term_id');
    }

    public function posts()
    {
        return $this->hasMany(WordpressPost::class, 'ID', 'object_id');
    }
}
