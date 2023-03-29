<?php
declare(strict_types=1);
namespace Cornatul\Wordpress\Tests\Unit;


use Cornatul\Feeds\Models\Article;
use Cornatul\Wordpress\Interfaces\WordpressRepositoryInterface;
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

        $wordpressRepository = Mockery::mock(WordpressRepositoryInterface::class);
        $wordpressRepository->shouldReceive('createSite')->andReturn(new \Cornatul\Wordpress\Models\WordpressWebsite());
        $this->assertInstanceOf(\Cornatul\Wordpress\Models\WordpressWebsite::class, $wordpressRepository->createSite([]));
    }

    public function testCanDeletePost():void
    {

        $wordpressRepository = Mockery::mock(WordpressRepositoryInterface::class);
        $wordpressRepository->shouldReceive('deleteSite')->andReturn(1);
        $this->assertEquals(1, $wordpressRepository->deleteSite(1));
    }

    public function testCanPaginatePost():void
    {

        $wordpressRepository = Mockery::mock(WordpressRepositoryInterface::class);
        $wordpressRepository->shouldReceive('paginate')->andReturn(new \Illuminate\Pagination\LengthAwarePaginator([], 1, 1));
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $wordpressRepository->paginate());
    }


}
