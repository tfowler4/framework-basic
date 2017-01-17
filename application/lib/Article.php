<?php

/**
 * article class
 */
class Article {
    public $articleId;
    public $title;
    public $content;
    public $categoryId;
    public $category;
    public $meta;

    public function __construct($data) {
        $this->articleId  = $data['article_id'];
        $this->title      = $data['title'];
        $this->content    = $data['content'];
        $this->categoryId = $data['category_id'];
        $this->category   = $data['category'];
        $this->meta       = $data['meta'];
    }
}