<?php

/**
 * static class to handle $_SESSION values
 */
class SessionData {
    /**
     * retrieve value from key
     *
     * @param  string $key [ session key in array ]
     *
     * @return mixed [ value from session ]
     */
    public static function get($key) {
        $value = '';

        if ( !empty($_SESSION[$key]) ) {
            $value = $_SESSION[$key];

            if ( is_string($value) ) {
                $value = trim($value);
            }
        }

        return $value;
    }

    /**
     * set session value
     *
     * @param  string $key [ session key in array ]
     *
     * @return void
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * remove key from session
     *
     * @param  string $key [ session key in array ]
     *
     * @return void
     */
    public static function remove($key) {
        $value = '';

        if ( !empty(self::get($key)) ) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * start session
     *
     * @return void
     */
    public static function start() {
        session_start();
    }

    /**
     * end active session
     *
     * @return void
     */
    public static function end() {
        if ( !empty(session_id()) ) {
            session_destroy();
        }
    }

    /**
     * resets the current session by ending and starting a new one
     *
     * @return void
     */
    public static function reset() {
        self::set('login', FALSE);
        self::set('admin', FALSE);
        self::set('user', NULL);
    }
}