<?php

/**
 * category class
 */
class Category {
    public $categoryId;
    public $name;
    public $meta;
    public $numOfArticles;

    public function __construct($data) {
        $this->categoryId    = $data['category_id'];
        $this->name          = $data['name'];
        $this->meta          = $data['meta'];
        $this->numOfArticles = $data['num_of_articles'];
    }
}