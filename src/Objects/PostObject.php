<?php

namespace LzoMedia\Wordpress\Objects;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;


class PostObject
{

    private string $postType;

    private string $title;

    private string $category;

    private string $content;

    private ?string $image;

    private string $source;

    private string $email;

    private string $author;

    private string $type;

    private string $status;

    private string $databaseConnection;

    private ?array $keywords;

    private ?array $tags;

    final public function getTitle(): string
    {
        return $this->title;
    }


    final public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    final public function getCategory(): string
    {
        return Str::ucfirst(str_replace('-', ' ', $this->category));
    }


    final public function setCategory(string $category): void
    {
        $this->category = $category;
    }


    final public function getContent(): string
    {
        return $this->content;
    }


    final public function setContent(string $content): void
    {
        $this->content = $content;
    }



    final public function getImage(): ?string
    {
        if ($this->image === '') {
            $crawler = new Crawler();
            $crawler->addHtmlContent($this->content);
            $this->image = $crawler->filter('img')->attr('src');
        }

        return $this->image;
    }


    final public function setImage(?string $image): void
    {
        $this->image = $image;
    }


    final public function getSource(): string
    {
        return str_replace('www.', '', $this->source);
    }


    final public function setSource(string $source): void
    {
        $this->source = $source;
    }


    final public function getEmail(): string
    {
        return $this->email;
    }

    final public function setEmail(string $email): void
    {

        $this->email = false;

        $regex = '/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';

        preg_match_all($regex, $email, $matches);

        foreach ($matches[0] as $found) {
            $this->email = $found;
        }
    }

    final public function getUnique(): string
    {
        return  md5($this->source);
    }

    public function getAuthor(): string
    {
        return $this->author ?? '1';
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getDatabaseConnection(): string
    {
        return $this->databaseConnection;
    }

    public function setDatabaseConnection(string $databaseConnection): void
    {
        $this->databaseConnection = $databaseConnection;
    }

    public function getPostType(): string
    {
        return $this->postType ?? "post";
    }

    public function setPostType(string $postType): void
    {
        $this->postType = $postType;
    }

    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    public function setKeywords(?array $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): void
    {
        $this->tags = $tags;
    }

}
