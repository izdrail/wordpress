<?php

namespace Cornatul\Wordpress\Models;

use Carbon\Carbon;
use Corcel\Model\Post;
use Corcel\Model\Term;
use Illuminate\Database\Query\Builder;

/**
 *  @package Development\Extractor\Models
 * Autocomplete the Builder methods (for example where(), get(), find(), findOrFail() etc...)
 *  * @mixin Builder
 */
class WordpressTerm extends Term
{
    protected $table = 'wp_terms';

    protected $primaryKey = 'term_id';

    public function taxonomies()
    {
        return $this->hasMany(WordpressTermTaxonomy::class, 'term_id');
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }
}
