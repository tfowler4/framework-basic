<?php

/**
 * static class to handle $_POST values
 */
class Post {
    /**
     * retrieve value from key
     *
     * @param  string $key [ field key from form ]
     *
     * @return string [ post value from key ]
     */
    public static function get($key) {
        $value = '';

        if ( isset($_POST[$key]) ) {
            $value = $_POST[$key];
        } elseif ( !empty($_FILES[$key]) ) {
            $value = $_FILES[$key];
        }

        return $value;
    }

    /**
     * get number of fields in POST
     *
     * @return integer [ number of fields in POST ]
     */
    public static function count() {
        $nonEmptyFields = 0;

        foreach( $_POST as $key => $value ) {
            $fieldValue = $_POST[$key];

            if ( !empty($fieldValue) ) {
                $nonEmptyFields++;
            }
        }

        return $nonEmptyFields;
    }
}