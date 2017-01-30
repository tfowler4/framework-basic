<?php

/**
 * alert class used to display at the top of the page
 */
class Alert {
    public $title;
    public $type;
    public $message;

    const DEFAULT_TITLE   = 'Uncategorized';
    const DEFAULT_TYPE    = 'info';
    const DEFAULT_MESSAGE = 'Woops! A blank message is here and it shouldn\'t be!';

    /**
     * constructor
     *
     * @param  array $data [ array containing alert data ]
     *
     * @return void
     */
    public function __construct($data) {
        if ( !empty($data) ) {
            $this->_setTitle($data);
            $this->_setType($data);
            $this->_setMessage($data);
        } else {
            $this->title   = DEFAULT_TITLE;
            $this->type    = DEFAULT_TYPE;
            $this->message = DEFAULT_MESSAGE;
        }
    }

    /**
     * sets the title of the alert
     *
     * @param  array $data [ array containing alert data ]
     *
     * @return void
     */
    private function _setTitle($data) {
        if ( !empty($data['title']) ) {
            $this->title = $data['title'];
        }
    }

    /**
     * sets the type of the alert
     *
     * @param  array $data [ array containing alert data ]
     *
     * @return void
     */
    private function _setType($data) {
        if ( !empty($data['type']) ) {
            $this->type = $data['type'];
        }
    }

    /**
     * sets the message of the alert
     *
     * @param  array $data [ array containing alert data ]
     *
     * @return void
     */
    private function _setMessage($data) {
        if ( !empty($data['message']) ) {
            $this->message = $data['message'];
        }
    }

    /**
     * get the html of the alert to display
     *
     * @return string [ html string containing the alert ]
     */
    public function getHtml() {
        $html = '';

        $html .= '<div class="row">';
            $html .= '<div class="alert alert-' . $this->type . ' alert-dismissible fade in">';
                $html .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                $html .= '<strong>' . $this->title . '</strong> <span>' . $this->message . '</span>';
            $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}