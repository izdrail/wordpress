<?php

namespace Cornatul\Wordpress\Models;

use Illuminate\Database\Eloquent\Model;

class WordpressTermRelationship extends Model
{
    protected $table = 'wp_term_relationships';

    protected $primaryKey = ['object_id', 'term_taxonomy_id'];

    public $incrementing = false;

    protected $fillable = [
        'object_id', 'term_taxonomy_id', 'term_order'
    ];

    public function termTaxonomy()
    {
        return $this->belongsTo(TermTaxonomy::class);
    }
}
