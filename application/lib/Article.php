<?php

/**
 * article class for displaying front page articles
 */
class Article {
    public $articleId;
    public $title;
    public $content;
    public $categoryId;
    public $category;
    public $meta;
    public $dateAdded;
    public $lastModified;

    /**
     * constructor
     *
     * @param  array $data [ array containing article data ]
     *
     * @return void
     */
    public function __construct($data) {
        $this->articleId    = $data['article_id'];
        $this->title        = $data['title'];
        $this->content      = $data['content'];
        $this->categoryId   = $data['category_id'];
        $this->category     = $data['category'];
        $this->meta         = $data['meta'];
        $this->dateAdded    = $data['date_added'];
        $this->lastModified = $data['last_modified'];
    }
}