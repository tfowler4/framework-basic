<?php

/**
 * header class
 */
class Header {
    public $headerItems = array();
    public $siteLogo;
    public $siteName;
    public $siteLink;

    /**
     * constructor
     */
    public function __construct() {
        $this->siteLink    = 'http://localhost/framework-basic';
        $this->siteLogo    = '';
        $this->siteName    = 'Test Site Name';
        $this->headerItems = array(
            array('title'          => 'Item 1',
                  'link'           => 'http://www.google.com',
                  'class'          => 'active',
                  'target'         => '_blank',
                  'icon'           => 'glyphicon glyphicon-tags',
                  'dropdown'       => false,
                  'dropdown_items' => array()
            ),
            array('title'          => 'Item 2',
                  'link'           => 'http://www.yahoo.com',
                  'class'          => '',
                  'target'         => '_blank',
                  'icon'           => 'glyphicon glyphicon-hdd',
                  'dropdown'       => false,
                  'dropdown_items' => array()
            ),
            array('title'          => 'Item 3',
                  'link'           => 'http://www.youtube.com',
                  'class'          => '',
                  'target'         => '_blank',
                  'icon'           => 'glyphicon glyphicon-info-sign',
                  'dropdown'       => false,
                  'dropdown_items' => array()
            ),
            array('title'          => 'Item 4',
                  'link'           => '#',
                  'class'          => '',
                  'dropdown'       => true,
                  'target'         => '',
                  'icon'           => 'glyphicon glyphicon-cloud-download',
                  'dropdown_items' => array(
                    array('title' => 'Item 1',
                          'link'  => 'http://www.google.com',
                          'icon'  => 'glyphicon glyphicon-blackboard'
                        ),
                    array('title' => 'Item 2',
                          'link'  => 'http://www.yahoo.com',
                          'icon'  => 'glyphicon glyphicon-education'
                        ),
                    array('title' => 'Item 3',
                          'link'  => 'http://www.youtube.com',
                          'icon'  => 'glyphicon glyphicon-modal-window'
                        )
                    )
            ),
        );
    }
}