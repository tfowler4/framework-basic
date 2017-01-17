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

        $this->setFieldRequired(array('name', 'meta'));
    }

    public function submitForm() {
        $response   = parent::MESSAGE_GENERIC;
        $dbResponse = FALSE;

        $this->prePopulateFields();

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

/**
 * edit category form
 */
class EditCategoryForm extends Form {
    public $id;
    public $name;
    public $meta;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article Category successfully saved!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while saving your Article Category!');

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired(array('id, name', 'meta'));
    }

    public function submitForm() {
        $response   = parent::MESSAGE_GENERIC;
        $dbResponse = FALSE;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            $dbResponse = $this->_updateCategorytoDb();

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

    private function _updateCategorytoDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "UPDATE
                category_table
            SET
                name = '%s',
                meta = '%s'
            WHERE
                category_id = '%d'",
            $this->name,
            $this->meta,
            $this->id
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}

class RemoveCategoryForm extends Form {
    public $id;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article Category successfully removed!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while removing your Article Category!');

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired(array('id'));
    }

    public function submitForm() {
        $response   = parent::MESSAGE_GENERIC;
        $dbResponse = FALSE;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            $dbResponsePrimary   = $this->_verifyRemainingCategoryArticles();
            $dbResponseSecondary = $this->_removeCategorytoDb();

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

    private function _verifyRemainingCategoryArticles() {
        $dbh = Database::getHandler();

        $clearedArticlesWithCategory = true;

        $query = sprintf(
            "SELECT
                COUNT(*) as num_of_articles
            FROM
                article_table
            WHERE
                category_id = '%d'
            GROUP BY
                category_id",
            $this->id
        );

        $query = $dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $numOfArticles = $row['num_of_articles'];

            if ( $numOfArticles > 0 ) {
                $clearedArticlesWithCategory = false;
            }

            break;
        }echo "HERE";
exit;
        return $clearedArticlesWithCategory;
    }

    private function _removeCategorytoDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "DELETE
                category_table
            WHERE
                category_id = '%d'",
            $this->id
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}

/**
 * create article form
 */
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

        $this->setFieldRequired(array('title', 'category', 'content'));
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

        $updateString        = '';
        $categories          = '';

        $query = sprintf(
            "SELECT
                category_id,
                COUNT(*) AS num_of_articles
            FROM
                article_table
            GROUP BY
                category_id"
        );

        $query = $dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $categoryId    = $row['category_id'];
            $numOfArticles = $row['num_of_articles'];

            $updateString .= ' WHEN ' . $categoryId . ' THEN ' . $numOfArticles . ' ';

            if ( !empty($categories) ) {
                $categories .= ',';
            }

            $categories .= $categoryId;
        }

        $query = sprintf(
            "UPDATE
                category_table
            SET
                num_of_articles = CASE category_id %s END
            WHERE
                category_id IN (%s)",
            $updateString,
            $categories
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}

/**
 * edit category form
 */
class EditArticleForm extends Form {
    public $id;
    public $title;
    public $category;
    public $content;

    const MESSAGE_SUCCESS = array('type' => 'success', 'title' => 'Success', 'message' => 'Article successfully saved!');
    const MESSAGE_ERROR   = array('type' => 'danger',  'title' => 'Error',   'message' => 'An Error occurred while saving your Article!');

    /* Test Lorem
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ultrices erat a lectus vestibulum, ac viverra velit ultrices. Vestibulum lacus tortor, finibus non dui non, posuere placerat enim. Sed ac fringilla velit. Phasellus non nunc ut leo facilisis auctor. Aliquam ac diam ipsum. Donec eget nunc lorem. In erat sapien, suscipit ut felis sed, rutrum vulputate eros. Nullam gravida justo vel arcu euismod, a molestie tellus auctor. Sed at nisl sagittis, porta mauris eget, tincidunt lorem. Nam magna erat, hendrerit sed egestas quis, pharetra vitae dolor
    */

    public function __construct() {
        parent::__construct();

        $this->setFieldRequired(array('id', 'title', 'category', 'content'));
    }

    public function submitForm() {
        $response   = parent::MESSAGE_GENERIC;
        $dbResponse = FALSE;

        $this->prePopulateFields();

        if ( $this->validateRequiredFields() ) {
            $dbResponsePrimary   = $this->_updateArticletoDb();
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

    private function _updateArticletoDb() {
        $dbh = Database::getHandler();

        $query = sprintf(
            "UPDATE
                article_table
            SET
                title = '%s',
                category_id = '%d',
                content = '%s'
            WHERE
                article_id='%d'",
            $this->title,
            $this->category,
            $this->content,
            $this->id
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }

    private function _updateCategoryArticleCount() {
        $dbh = Database::getHandler();

        $updateString        = '';
        $categories          = '';

        $query = sprintf(
            "SELECT
                category_id,
                COUNT(*) AS num_of_articles
            FROM
                article_table
            GROUP BY
                category_id"
        );

        $query = $dbh->query($query);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $categoryId    = $row['category_id'];
            $numOfArticles = $row['num_of_articles'];

            $updateString .= ' WHEN ' . $categoryId . ' THEN ' . $numOfArticles . ' ';

            if ( !empty($categories) ) {
                $categories .= ',';
            }

            $categories .= $categoryId;
        }

        $query = sprintf(
            "UPDATE
                category_table
            SET
                num_of_articles = CASE category_id %s END
            WHERE
                category_id IN (%s)",
            $updateString,
            $categories
        );

        $query = $dbh->prepare($query);

        return $query->execute();
    }
}