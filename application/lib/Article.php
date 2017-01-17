<?php

/**
 * article class
 */
class Article {
    public $articleId;
    public $title;
    public $content;
    public $footer;
    public $selected;

    public function __construct($data) {
        $this->articleId = $data['article_id'];
        $this->title     = $data['title'];
        $this->content   = $data['content'];
        $this->footer    = $data['category'];
    }
}