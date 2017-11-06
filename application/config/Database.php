<?php

/**
 * database handling class
 */
class Database {
    private static $_username;
    private static $_password;
    private static $_dbName;
    private static $_dbHost;
    private static $_dbPort;
    private static $_dbh;

    /**
     * initialize a database object with connection parameters
     *
     * @param  string $username [ user name for database ]
     * @param  string $password [ password for database ]
     * @param  string $dbName   [ name of database ]
     * @param  string $dbHost   [ host location for database ]
     *
     * @return void
     */
    public static function init($username, $password, $dbName, $dbHost, $dbPort) {
        self::$_username = $username;
        self::$_password = $password;
        self::$_dbName   = $dbName;
        self::$_dbHost   = $dbHost;
        self::$_dbPort   = $dbPort;

        self::_connect();
    }

    /**
     * initialize connection to database
     *
     * @return void
     */
    private static function _connect() {
        try {
            self::$_dbh = new PDO('mysql:host=' . self::$_dbHost . ';port=' . self::$_dbPort . ';dbname=' . self::$_dbName . ';charset=UTF8', self::$_username, self::$_password);
            self::$_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch ( PDOException $e ) {
            die('Connection error: ' . $e->getMessage());
        }
    }

    /**
     * get a database handler, create a new one if one doesn't exist
     *
     * @return self
     */
    public static function getHandler() {
        if ( !self::$_dbh ) {
            new Database();
        }

        return self::$_dbh;
    }

    /**
     * magic clone to prevent duplicates
     *
     * @return void
     */
    public function __clone() {}
}