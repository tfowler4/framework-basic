<?php

class Alert {
    public $title;
    public $type;
    public $message;

    const DEFAULT_TITLE   = 'Uncategorized';
    const DEFAULT_TYPE    = 'info';
    const DEFAULT_MESSAGE = 'Woops! A blank message is here and it shouldn\'t be!';

    public function __construct($data) {
        if ( !empty($data) ) {
            $this->_setTitle($data);
            $this->_setType($data);
            $this->_setMessage($data);
        }
    }

    private function _setTitle($data) {
        if ( !empty($data['title']) ) {
            $this->title = $data['title'];
        }
    }

    private function _setType($data) {
        if ( !empty($data['type']) ) {
            $this->type = $data['type'];
        }
    }

    private function _setMessage($data) {
        if ( !empty($data['message']) ) {
            $this->message = $data['message'];
        }
    }
}