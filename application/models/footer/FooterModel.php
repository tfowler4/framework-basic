<?php

/**
 * footer class
 */
class FooterModel extends AbstractModel {
    public $footerItems = array();

    const MODEL_NAME = 'Footer';

    /**
     * constructor
     *
     * @param obj $dbh [ database handler ]
     *
     * @return void
     */
    public function __construct($dbh) {
        parent::__construct($dbh);

        $this->footerItems = array(
            array('title'          => 'Item 1',
                  'link'           => 'http://www.google.com',
                  'text'           => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices.',
                  'target'         => '_blank',
                  'color'          => 'primary',
                  'icon'           => 'glyphicon glyphicon-tags'
            ),
            array('title'          => 'Item 2',
                  'link'           => 'http://www.yahoo.com',
                  'text'           => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices.',
                  'target'         => '_blank',
                  'color'          => 'success',
                  'icon'           => 'glyphicon glyphicon-hdd'
            ),
            array('title'          => 'Item 3',
                  'link'           => 'http://www.youtube.com',
                  'text'           => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices.',
                  'target'         => '_blank',
                  'color'          => 'info',
                  'icon'           => 'glyphicon glyphicon-info-sign'
            ),
            array('title'          => 'Item 4',
                  'link'           => 'http://www.facebook.com',
                  'text'           => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices.',
                  'target'         => '_blank',
                  'color'          => 'warning',
                  'icon'           => 'glyphicon glyphicon-cloud-download'
            ),
            array('title'          => 'Item 5',
                  'link'           => 'http://www.cnn.com',
                  'text'           => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices.',
                  'target'         => '_blank',
                  'color'          => 'default',
                  'icon'           => 'glyphicon glyphicon-cloud'
            ),
            array('title'          => 'Item 6',
                  'link'           => 'http://www.twitter.com',
                  'text'           => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices.',
                  'target'         => '_blank',
                  'color'          => 'danger',
                  'icon'           => 'glyphicon glyphicon-signal'
            )
        );
    }
}
