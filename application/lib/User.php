<?php

/**
 * user class for holding user details
 */
class User {
    public $userId;
    public $username;
    public $emailAddress;
    public $accountType;
    public $active;
    public $locked;
    public $dateJoined;

    /**
     * constructor
     *
     * @param  array $data [ array containing user data ]
     *
     * @return void
     */
    public function __construct($data) {
        $this->userId       = $data['user_id'];
        $this->username     = $data['username'];
        $this->emailAddress = $data['email_address'];
        $this->dateJoined   = $data['date_added'];
        $this->accountType  = $data['account_type'];
        $this->active       = $data['active'];
        $this->locked       = $data['locked'];
    }
}