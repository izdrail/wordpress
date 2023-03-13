<?php

namespace Cornatul\Wordpress\Jobs;



use App\Models\Article;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LzoMedia\Wordpress\Models\WordpressPost;
use LzoMedia\Wordpress\Models\WordpressTaxonomies;
use LzoMedia\Wordpress\Models\WordpressTerm;
use LzoMedia\Wordpress\Objects\PostObject;

/**
 * Class CreateWordpressPost
 */
class CreateWordpressPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public PostObject $postObject;

    public function __construct(Article $article)
    {
        $this->postObject = new PostObject();
        $this->postObject->setImage($article->image);
        $this->postObject->setTitle($article->title);
        $this->postObject->setContent($article->content);
        $this->postObject->setStatus('publish');
        $this->postObject->setType('post');
        $this->postObject->setAuthor(1);
        $this->postObject->setDatabaseConnection('wordpress');
        $this->postObject->setCategory($article->category->name);
        $this->postObject->setTags($article->tags()->pluck('name')->toArray());
    }

    final public function handle(): void
    {

        try {
            $this->createPost();
        } catch (Exception $exception) {
            Log::alert("Something went wrong saving the data {$exception->getMessage()}");
        }
    }

    final public function createPost(string $postType = "post"): WordpressPost
    {

        log::info('Creating post');

        $model = new WordpressPost();

        $model->setConnection($this->postObject->getDatabaseConnection());
        $exists = $model->where('post_title', $this->postObject->getTitle())
            ->where('post_status', 'publish')
            ->get()
            ->first();
        log::info('Checking if post exists' . $exists);

        if (is_null($exists)) {
            $model->post_title = $this->postObject->getTitle();

            $model->post_name = Str::slug(
                $this->postObject->getTitle()
            );
            log::info('Entering post creation logic');

            $model->post_content = $this->postObject->getContent();
            $model->post_content_filtered = '';

            $model->post_excerpt = Str::words(
                $this->postObject->getContent()
            );

            $this->postObject->setPostType($postType);

            $model->post_type = $this->postObject->getPostType();

            $model->to_ping = true;
            $model->pinged = false;

            $model->save();

            try {
                $this->saveMeta($model);

                $category = $this->attachOrCreateCategory();

                $model->taxonomies()->save($category);
            } catch (Exception $exception) {
                info($exception->getMessage() . $exception->getTraceAsString());
            }
            return $model;
        }

        return $exists;
    }

    private function attachOrCreateCategory(): WordpressTaxonomies
    {
        $term = $this->findOrCreateTerm();

        $taxonomy = new WordpressTaxonomies();

        $taxonomy->setConnection($this->postObject->getDatabaseConnection());

        $taxonomy = $taxonomy->where(
            'term_id',
            $term->getAttributeValue('term_id')
        )->first();

        if ($taxonomy === null) {
            $term = $this->findOrCreateTerm();

            $taxonomy = new WordpressTaxonomies();

            $taxonomy->setConnection($this->postObject->getDatabaseConnection());

            $taxonomy->setAttribute('taxonomy', 'category');

            $taxonomy->setAttribute('description', $this->postObject->getCategory());

            $taxonomy->setAttribute('term_id', $term->getAttributeValue('term_id'));

            $taxonomy->save();

            return $taxonomy;
        }

        $taxonomy->increment('count');
        return $taxonomy;
    }

    private function findOrCreateTerm(): WordpressTerm
    {

        $term = new WordpressTerm();

        $term->setConnection($this->postObject->getDatabaseConnection());

        $term = $term->where('name', $this->postObject->getCategory())
            ->get()
            ->first();

        if (is_null($term)) {
            $term = new WordpressTerm();

            $term->setConnection($this->postObject->getDatabaseConnection());

            $term->setAttribute('name', $this->postObject->getCategory());

            $term->setAttribute('slug', $this->postObject->getCategory());

            $term->save();

            return $term;
        }
        return $term;
    }

    private function saveMeta(WordpressPost $model): void
    {
        $model->saveMeta('postImage', $this->postObject->getImage());
        $model->saveMeta('postAuthor', $this->postObject->getAuthor());
    }
}
