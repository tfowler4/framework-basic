<?php

/**
 * category class for article segmentation
 */
class Category {
    public $categoryId;
    public $name;
    public $meta;
    public $numOfArticles;

    /**
     * constructor
     *
     * @param  array $data [ array containing category data ]
     *
     * @return void
     */
    public function __construct($data) {
        $this->categoryId    = $data['category_id'];
        $this->name          = $data['name'];
        $this->meta          = $data['meta'];
        $this->numOfArticles = $data['num_of_articles'];
    }
}