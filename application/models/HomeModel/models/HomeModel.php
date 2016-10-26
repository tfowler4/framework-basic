<?php

/**
 * home model
 */
class HomeModel extends Model {
    public $content = array();

    /**
     * constructor
     */
    public function __construct($module, $params) {
        parent::__construct();
        $this->pageTitle = 'Home';

        $this->content = $this->_getContent();

        $articles = $this->_selectQuery('article_table', array('article_id', 'title', 'body', 'editor'), '');
    }

    protected function _getContent() {
        $content = array();

        for ( $i = 0; $i < 5; $i++ ) {
            $stdObj = new stdClass();
            $stdObj->title  = 'Panel Title';
            $stdObj->body   = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices. Vestibulum lacus tortor, finibus non dui non, posuere placerat enim. Sed ac fringilla velit. Phasellus non nunc ut leo facilisis auctor. Aliquam ac diam ipsum. Donec eget nunc lorem. In erat sapien, suscipit ut felis sed, rutrum vulputate eros. Nullam gravida justo vel arcu euismod, a molestie tellus auctor. Sed at nisl sagittis, porta mauris eget, tincidunt lorem. Nam magna erat, hendrerit sed egestas quis, pharetra vitae dolor.';
            $stdObj->footer = 'Panel Footer';

            array_push($content, $stdObj);
        }

        return $content;
    }
}