<?php

/**
 * base model class
 */
abstract class Model {
    public $title;
    public $description;

    /**
     * constructor
     */
    public function __construct() {

    }

    /**
     * magic getter
     */
    public function __get($name) {
        if ( isset($this->$name) ) {
            return $this->$name;
        }
    }

    /**
     * magic setter
     */
    public function __set($name, $value) {
        $this->$name = $value;
    }

    /**
     * magic isset
     */
    public function __isset($name) {
        return isset($this->$name);
    }

    /**
     * magic destruct
     */
    public function __destruct() {}

    /**
     * magic unset
     */
    public function __unset($name) {
        unset($this->$name);
    }
}