<?php

if ( !defined('SITE_NAME') ) { die('Direct access not permitted'); }

/**
 * backup database maintenance script
 */
class BackupDatabase implements ScriptInterface {
    private $_backupFileName;
    private $_backupPath;
    private $_oldBackupPath;
    private $_response;

    /**
     * constructor
     *
     * @return void
     */
    public function __construct() {
        logger(0, 'Starting Backup Database...', 'dev');

        $this->setResponse('warning', 'Backup had a Warning!');

        $this->_backupFileName =  DB_NAME . date("Y-m-d_H-i"). '.sql';

        $this->checkVariables();

        $this->execute();

        $this->endScript();
    }

    /**
     * begin execution of the script
     *
     * @return void
     */
    public function execute() {
        try {
            $command = 'mysqldump --no-defaults -h' . DB_HOST . ' -u' . DB_USER . ' -p' . DB_PASS . ' ' . DB_NAME . ' > ' . FOLDER_SCRIPTS . $this->_backupFileName;
            exec($command, $output, $return);

            if ( $return ) {
                throw new Exception('Error with executing mysqldump command');
            }
        } catch (Exception $e) {
            logger(3, $e->getMessage(), 'dev');
            $this->setResponse('fail', $e->getMessage());

            $this->endScript();
        }


        logger(1, 'Backup File: ' . $this->_backupFileName . '...', 'dev');

        $this->_moveFile();
    }

    /**
     * check any parameters sent to configure the script execution
     *
     * @return void
     */
    public function checkVariables() {}

    /**
     * set the response the script will return if it were to end
     *
     * @param string $status  [ status of script if success, fail, or warning ]
     * @param string $message [ response message for the script ]
     *
     * @return void
     */
    public function setResponse($status, $message) {
        $this->_response['status']   = $status;
        $this->_response['response'] = $message;
    }

    /**
     * end the script and log any messages if needed
     *
     * @return void
     */
    public function endScript() {
        echo json_encode($this->_response);
        die();
    }

    /**
     * relocate the file from the script folder to its proper folder
     *
     * @return void
     */
    private function _moveFile() {
        $dateYear  = date('Y');
        $dateMonth = date('n')."-".date('M');
        $dateDay   = date('d');
        $fullDate  = $dateYear . '/' . $dateMonth . '/' . $dateDay;

        $this->_oldBackupPath = FOLDER_SCRIPTS . $this->_backupFileName;
        $this->_backupPath    = FOLDER_BACKUPS . $fullDate;

        if ( !file_exists($this->_backupPath) ) {
            if ( !mkdir($this->_backupPath, 0777, true) ) {
                logger(3, 'Folder unable to be created at location: ' . $this->_backupPath, 'dev');
                $this->setResponse('fail', 'Backup failed!');

                $this->endScript();
            }
        }

        $this->_backupPath = $this->_backupPath . '/' . $this->_backupFileName;

        try {
            if ( rename($this->_oldBackupPath, $this->_backupPath) === FALSE ) {
                throw new Exception('Unable to rename ' . $this->_oldBackupPath . ' to ' . $this->_backupPath);
            }
        } catch ( Exception $e ) {
            logger(3, $e->getMessage(), 'dev');
            $this->setResponse('fail', $e->getMessage());

            $this->endScript();
        }

        logger(1, 'Backup Database Completed!', 'dev');
        $this->setResponse('success', 'Backup Database Completed!');
    }
}

new BackupDataBase();