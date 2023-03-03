<?php

namespace Cornatul\Wordpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WordpressWebsite
 * @package Cornatul\Wordpress\Models
 * @method static create(array $data)
 * @method static paginate(int $limit)
 */
class WordpressWebsite extends Model
{
    protected $table = 'wordpress_websites';

    protected $fillable = [
        'database_host',
        'database_user',
        'database_pass',
        'database_name',
    ];
}
