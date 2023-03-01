<?php

namespace LzoMedia\Wordpress\Models;

use Carbon\Carbon;
use Corcel\Model\Post;
use Illuminate\Database\Eloquent\Builder;
/**
 *  @package Development\Extractor\Models
 * Autocomplete the Builder methods (for example where(), get(), find(), findOrFail() etc...)
 * @mixin Builder
 * @property string $post_title
 * @property string $post_name
 * @property string $post_content
 * @property string $post_excerpt
 * @property string $post_status
 * @property string $post_type
 * @property string $post_mime_type
 * @property string $comment_status
 * @property string $ping_status
 * @property string $post_password
 * @property string $post_parent
 * @property string $post_modified
 * @property string $post_modified_gmt
 * @property string $post_content_filtered
 * @property string $post_author
 * @property string $post_date
 * @property string $post_date_gmt
 * @property string $post_guid
 * @property string $post_time
 * @property string $to_ping
 * @property string $pinged
 */

class WordpressPost extends Post
{
    protected $postType = 'post';
}
