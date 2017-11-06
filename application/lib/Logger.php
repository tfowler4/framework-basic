<?php

/**
 * logger class for when handling site error & database logging
 */
class Logger {
    private $_timestamp;
    private $_userType;
    private $_logFilePath;
    private $_logFile;
    private $_logMessage;
    private $_severity;

    const SEVERITY = array(
        'DBUG',
        'INFO',
        'WARN',
        'EROR'
    );

    /**
     * log call to write log entry
     *
     * @param  int    $severity [ level of severity integer ]
     * @param  string $message  [ log message ]
     * @param  string $userType [ client type ]
     *
     * @return void
     */
    public function log($severity, $message, $userType = 'user') {
        $this->_setTimestamp();
        $this->_setUserType($userType);
        $this->_setSeverity($severity);
        $this->_setLogMessage($message);
        $this->_setFolderPath();
        $this->_setLogFile();
        $this->_logMsgToFile();
        $this->_logMsgToDb();
    }

    /**
     * set timestamp for log entry
     *
     * @return void
     */
    private function _setTimestamp() {
        $timestamp = date('Y-m-d H:i');
        $this->_timestamp = $timestamp;
    }

    /**
     * set user type depending on supplied value
     *
     * @param string $userType [ client type ]
     *
     * @return void
     */
    private function _setUserType($userType) {
        switch ( $userType ) {
            case 'user':
                $this->_userType = 'user';
                break;
            case 'admin':
            case 'dev':
                $this->_userType = 'dev';
                break;
            default:
                $this->_userType = 'user';
                break;
        }
    }

    /**
     * set severity level of log entry
     *
     * @param  int $severity [ level of severity integer ]
     *
     * @return void
     */
    private function _setSeverity($severity) {
        $severityIndex = 0;

        if ( !empty($severity) && is_numeric($severity) ) {
            $severityIndex = $severity;
        }

        if ( array_key_exists($severityIndex, self::SEVERITY) && !empty(self::SEVERITY[$severityIndex]) ) {
            $this->_severity = self::SEVERITY[$severityIndex];
        } else {
            $this->_severity = 'BASE';
        }
    }

    /**
     * sets log message for entry
     *
     * @param string $message [ log message ]
     *
     * @return void
     */
    private function _setLogMessage($message) {
        if ( is_string($message) ) {
            $this->_logMessage = preg_replace('/\s+/', ' ', trim($message));
        } else {
            $this->_logMessage = '';
        }
    }

    /**
     * set folder path for logging
     *
     * @return void
     */
    private function _setFolderPath() {
        $year  = date('Y');
        $month = date('n') . '-' . date('M');

        switch ( $this->_userType ) {
            case 'user':
                $this->_logFilePath = strtolower(ABS_BASE_PATH . 'data/logs/user/' . $year . '/' . $month);
                break;
            case 'dev':
                $this->_logFilePath = strtolower(ABS_BASE_PATH . 'data/logs/dev/' . $year . '/' . $month);
                break;
        }

        if ( !file_exists($this->_logFilePath) ) {
            mkdir($this->_logFilePath, 0777, true);
        }
    }

    /**
     * set log file path
     *
     * @return void
     */
    private function _setLogFile() {
        $currentDate = date('Y-m-d');

        $this->_logFile = strtolower($this->_logFilePath . '/' . $currentDate . '.txt');
    }

    /**
     * log the entry into the database
     *
     * @return void
     */
    private function _logMsgToDB() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "INSERT INTO
                log_table (severity, user_type, session_id, timestamp, message)
            values
                ('%s', '%s', '%s', '%s', '%s')",
            $this->_severity,
            $this->_userType,
            session_id(),
            $this->_timestamp,
            $this->_logMessage
        );

        $query = $dbh->prepare($query);

        $query->execute();
    }

    /**
     * log the entry into the text file
     *
     * @return void
     */
    private function _logMsgToFile() {
        $fileHandle = fopen($this->_logFile, 'a+');
        $logMsg     = $this->_timestamp . ' | ' . $this->_severity . ' | ' . $this->_userType . ' | ' . session_id() . ' | ' . $this->_logMessage;

        fwrite($fileHandle, $logMsg . PHP_EOL);
        fclose($fileHandle);
    }
}