<?php

/**
 * base model class
 */
abstract class Model {
    public $pageTitle;
    public $pageDescription;
    public $db;

    /**
     * constructor
     */
    public function __construct() {
        $this->db = Database::getHandler();
    }

    protected function _selectQuery($table, $fields, $orderby) {
        $fields = $this->_extractFields($fields);
        $queryString  = 'SELECT ' . $fields;
        $queryString .= ' FROM ' . $table;

        $query = $this->db->query(sprintf($queryString));

        return $query->fetch(PDO::FETCH_ASSOC);
        /*
            private static function _getServers() {
                $query = self::$_dbh->query(sprintf(
                    "SELECT server_id,
                            name,
                            country,
                            region,
                            type,
                            type2
                       FROM %s
                   ORDER BY region ASC, name ASC",
                    self::TABLE_SERVERS
                    ));
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) { $row['name'] = utf8_encode($row['name']); CommonDataContainer::$serverArray[$row['name']] = new Server($row); }
            }
         */
    }

    protected function _extractFields($fields) {
        $queryFields = '';

        foreach( $fields as $field ) {
            if ( !empty($queryFields) ) {
                $queryFields .= ',';
            }

            $queryFields .= $field;
        }

        return $queryFields;
    }

    public function loadFragment($fragment) {

    }
}