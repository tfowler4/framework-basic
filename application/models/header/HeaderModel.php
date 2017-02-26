<?php

/**
 * header class
 */
class HeaderModel extends AbstractModel {
    public $headerItems = array();
    public $siteLogo;
    public $siteName;
    public $siteLink;
    public $activeModel;

    const MODEL_NAME = 'Header';

    /**
     * constructor
     *
     * @param  obj $dbh         [ database handler ]
     * @param  obj $activeModel [ current active page model ]
     *
     * @return void
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

    /**
     * add attributes to navigation array item
     *
     * @param  array $navItem [ navigation item ]
     *
     * @return array [ navigation item ]
     */
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

    /**
     * sets site header navigation items
     *
     * @return void
     */
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

        // Github
        $navItem = array('id' => 'git-nav','title' => 'GitHub', 'model' => ' ', 'link' => 'http://www.github.com/tfowler4', 'icon' => 'fa fa-github-alt', 'dropdown' => array());
        array_push($navigationArray, $navItem);

        // navigation
        define('NAV', serialize($navigationArray));
    }
}