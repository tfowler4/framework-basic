<?php

/**
 * header class
 */
class Header {
    public $headerItems = array();
    public $siteLogo;
    public $siteName;
    public $siteLink;
    public $activeModel;

    /**
     * constructor
     */
    public function __construct($activeModel) {
        $this->siteName    = SITE_NAME;
        $this->siteLink    = SITE_URL;
        $this->siteLogo    = '';
        $this->activeModel = $activeModel;

        foreach( unserialize(NAV) as $navItem ) {
            array_push($this->headerItems, $this->_createNavItem($navItem));
        }
    }

    private function _createNavItem($navItem) {
        if ( empty($navItem['link']) ) {
            $navItem['link'] = SITE_URL . strtolower($navItem['model']);
            $navItem['target'] = '_self';
        } else {
            $navItem['target'] = '_blank';
        }

        if ( $this->activeModel == $navItem['model'] ) {
            $navItem['class'] = 'active';
        } else {
            $navItem['class'] = '';
        }

        return $navItem;
    }
}
