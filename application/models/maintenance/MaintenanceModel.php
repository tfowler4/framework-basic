<?php

/**
 * maintenance model
 */
class MaintenanceModel extends AbstractModel {
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
    }

    /**
     * get all scripts from scripts folder
     *
     * @return array [ list of script items in script folder ]
     */
    public function getScripts() {
        $listOfScripts = array();

        $script = $this->setScriptItem('Test Script', 'test.php', 'Just a tester');
        if ( $script != null ) { array_push($listOfScripts, $script); }

        $script = $this->setScriptItem('Backup Database', 'backupDatabase.php', 'Backup the entire database with timestamp');
        if ( $script != null ) { array_push($listOfScripts, $script); }

        return $listOfScripts;
    }

    public function setScriptItem($title, $fileName, $description) {
        $item = array();

        if ( !file_exists(FOLDER_SCRIPTS . $fileName) ) {
            return null;
        }

        $item['title']       = $title;
        $item['file']        = $fileName;
        $item['description'] = $description;

        return $item;
    }
}