<?php

/**
 * administration model
 */
class AdminModel extends AbstractModel {
    const MODEL_NAME = 'Admin';

    /**
     * constructor
     *
     * @param obj   $dbh    [ database handler ]
     * @param array $params [ parameters sent by the url ]
     *
     * @return void
     */
    public function __construct($dbh, $params) {
        parent::__construct($dbh);

        $this->_loadForms();
    }

    /**
     * load all forms associated with model
     *
     * @return void
     */
    protected function _loadForms() {
        $this->forms = new stdClass();
        $this->forms->createArticle  = new CreateArticleForm($this->_dbh);
        $this->forms->createCategory = new CreateCategoryForm($this->_dbh);
        $this->forms->editArticle    = new EditArticleForm($this->_dbh);
        $this->forms->editCategory   = new EditCategoryForm($this->_dbh);
        $this->forms->removeCategory = new RemoveCategoryForm($this->_dbh);
        $this->forms->removeArticle  = new RemoveArticleForm($this->_dbh);

        foreach ( $this->forms as $form ) {
            $form->repopulateForm($form);
        }
    }

    /**
     * get a list of all articles from database
     *
     * @return array [ list of articles ]
     */
    public function getArticles() {
        $articles = array();
        $database = new DatabaseModel($this->_dbh);
        $query    = $database->getAllArticles();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row);

            array_push($articles, $article);
        }

        return $articles;
    }

    /**
     * get a list of all article categories from database
     *
     * @return array [ list of categories ]
     */
    public function getCategories() {
        $categories = array();
        $database   = new DatabaseModel($this->_dbh);
        $query      = $database->getAllCategories();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category($row);

            array_push($categories, $category);
        }

        return $categories;
    }

    /**
     * get all scripts from scripts folder
     *
     * @return array [ list of script items in script folder ]
     */
    public function getScripts() {
        $listOfScripts = array();

        $script = $this->setScriptItem('Test Script', 'test', 'Just a tester');
        if ( $script != null ) { array_push($listOfScripts, $script); }

        $script = $this->setScriptItem('Backup Database', 'backupDatabase', 'Backup the entire database with timestamp');
        if ( $script != null ) { array_push($listOfScripts, $script); }

        return $listOfScripts;
    }

    public function setScriptItem($title, $fileName, $description) {
        $item = array();

        if ( !file_exists(FOLDER_SCRIPTS . $fileName . '.php') ) {
            return null;
        }

        $item['title']       = $title;
        $item['file']        = $fileName;
        $item['description'] = $description;

        return $item;
    }
}