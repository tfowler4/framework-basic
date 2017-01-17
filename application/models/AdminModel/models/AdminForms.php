<?php

/**
 * create category form
 */
class CreateCategoryForm extends Form {
    public $name;
    public $meta;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article Category successfully created!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while creating your Article Category!');

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired('name');
    }

    public function submitForm() {
        $response   = parent::MESSAGE_GENERIC;
        $dbResponse = FALSE;

        if ( $this->validateRequiredFields() ) {
            $dbResponse = $this->_insertCategorytoDb();

            if ( $dbResponse ) {
                $response = self::MESSAGE_SUCCESS;
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = self::MESSAGE_ERROR;
        }

        return $response;
    }

    private function _insertCategorytoDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "INSERT INTO
                category_table (name, meta)
            values
                ('%s', '%s')",
            $this->name,
            $this->meta
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}

class CreateArticleForm extends Form {
    public $title;
    public $category;
    public $content;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article successfully created!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while creating your Article!');

    /* Test Lorem
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices. Vestibulum lacus tortor, finibus non dui non, posuere placerat enim. Sed ac fringilla velit. Phasellus non nunc ut leo facilisis auctor. Aliquam ac diam ipsum. Donec eget nunc lorem. In erat sapien, suscipit ut felis sed, rutrum vulputate eros. Nullam gravida justo vel arcu euismod, a molestie tellus auctor. Sed at nisl sagittis, porta mauris eget, tincidunt lorem. Nam magna erat, hendrerit sed egestas quis, pharetra vitae dolor
    */

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired('title', 'content');
    }

    public function submitForm() {
        $response   = parent::MESSAGE_GENERIC;
        $dbResponse = FALSE;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            $dbResponsePrimary   = $this->_insertArticletoDb();
            $dbResponseSecondary = $this->_updateCategoryArticleCount();

            if ( $dbResponsePrimary && $dbResponseSecondary ) {
                $response = self::MESSAGE_SUCCESS;
            } else {
                $response = self::MESSAGE_ERROR;
            }
        } else {
            $response = self::MESSAGE_ERROR;
        }

        return $response;
    }

    private function _insertArticletoDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "INSERT INTO
                article_table (title, category_id, content)
            values
                ('%s', '%d', '%s')",
            $this->title,
            $this->category,
            $this->content
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }

    private function _updateCategoryArticleCount() {
        $dbh = Database::getHandler();

        // update count for category
        $query = sprintf(
            "UPDATE
                category_table
            SET
                num_of_articles = num_of_articles + 1
            WHERE
                category_id=%d",
            $this->category
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}