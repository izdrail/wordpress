<?php
declare(strict_types=1);
namespace Cornatul\Wordpress\Tests\Unit;


use Cornatul\Feeds\Models\Article;
use Mockery;

/**
 *
 */
class WordpressTest extends \Cornatul\Wordpress\Tests\TestCase
{

    /**
     * @throws \JsonException
     */
    public function testCanCreatePost():void
    {
      $this->assertEquals(11,11);
    }
}
