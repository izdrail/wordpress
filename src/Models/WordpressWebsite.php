<?php

namespace Cornatul\Wordpress\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WordpressWebsite
 * @package Cornatul\Wordpress\Models
 * @method static create(array $data)
 * @method static paginate(int $limit)
 * @method static find(int $id)
 * @property string database_host
 * @property string database_user
 * @property string database_pass
 * @property string database_name
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
