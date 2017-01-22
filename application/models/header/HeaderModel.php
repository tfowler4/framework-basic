<?php

/**
 * header class
 */
class HeaderModel extends Model {
    public $headerItems = array();
    public $siteLogo;
    public $siteName;
    public $siteLink;
    public $activeModel;

    /**
     * constructor
     */
    public function __construct($dbh, $activeModel) {
        parent::__construct($dbh);

        $this->siteName    = SITE_NAME;
        $this->siteLink    = SITE_URL;
        $this->siteLogo    = '';
        $this->activeModel = $activeModel;

        $this->_loadSiteNavigation();

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

    private function _loadSiteNavigation() {
        $navigationArray = array();

        // Biography
        $navItem = array('id' => 'bio-nav','title' => 'Bio', 'model' => 'Bio', 'link' => '', 'icon' => 'glyphicon glyphicon-user', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // Resume
        $navItem = array('id' => 'resume-nav','title' => 'Resume', 'model' => 'Resume', 'link' => '', 'icon' => 'fa fa-file-pdf-o', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // Portfolio
        $navItem = array('id' => 'portfolio-nav','title' => 'Portfolio', 'model' => 'Portfolio', 'link' => '', 'icon' => 'fa fa-file-text', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // Example Page
        $navItem = array('id' => 'example-nav','title' => 'Example', 'model' => 'Example', 'link' => '', 'icon' => 'fa fa-info-circle', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // Admin
        //$navItem = array('id' => 'admin-nav', 'title' => 'Administrator', 'model' => 'Admin', 'link' => '', 'icon' => 'fa fa-lock', 'dropdown' => array());
        //array_push($navigationArray, $navItem);

        // Github
        $navItem = array('id' => 'git-nav','title' => 'GitHub', 'model' => ' ', 'link' => 'http://www.github.com/tfowler4', 'icon' => 'fa fa-github-alt', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // navigation
        define('NAV', serialize($navigationArray));
    }
}