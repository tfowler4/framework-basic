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

    public function formInput($labelName, $fieldName, $fieldType, $placeHolder, $value, $isDisabled = '') {
        $id   = 'input-' . strtolower($fieldName) . '-' . $fieldType;
        $html ='';

        $html .= '<div class="form-group">';
            $html .= '<label for="' . $id . '">' . $labelName  . '</label>';
            $html .= '<input type="' . $fieldType . '" class="form-control" id="' . $id . '" placeholder="' . $placeHolder . '" value="' . $value . '" ' . $isDisabled . '>';
        $html .= '</div>';

        return $html;
    }

    public function formCheckboxes($labelName, $fieldName, $checkBoxes) {
        $html ='';

        $html .= '<div class="form-group">';
            $html .= '<label>' . $labelName  . '</label><br>';

            foreach( $checkBoxes as $checkBox ) {
                $html .= '<div class="checkbox' . $checkBox->inline . ' ' . $checkBox->disabled . '">';
                    $html .= '<label>';
                        $html .= '<input type="checkbox" value="' . $checkBox->value . '" ' . $checkBox->disabled . '>';
                        $html .= $checkBox->labelName;
                    $html .= '</label>';
                $html .= '</div>';
            }
        $html .= '</div>';

        return $html;
    }

    public function formRadioButtons($labelName, $fieldName, $radioButtons) {
        $html ='';

        $html .= '<div class="form-group">';
            $html .= '<label>' . $labelName  . '</label><br>';

            foreach( $radioButtons as $radioButton ) {
                $html .= '<div class="radio' . $radioButton->inline . ' ' . $radioButton->disabled . '">';
                    $html .= '<label>';
                        $html .= '<input type="radio" name="' . $fieldName . '" value="' . $radioButton->value . '" ' . $radioButton->disabled . '>';
                        $html .= $radioButton->labelName;
                    $html .= '</label>';
                $html .= '</div>';
            }
        $html .= '</div>';

        return $html;
    }

    public function formSelect($labelName, $fieldName, $selectOptions) {
        $id   = 'select-' . strtolower($fieldName);
        $html ='';

        $html .= '<div class="form-group">';
            $html .= '<label for="' . $id . '">' . $labelName  . '</label>';
            $html .= '<select class="form-control" id="' . $id . '">';
                foreach( $selectOptions as $option ) {
                    $html .= '<option value="' . $option->value . '">' . $option->text . '</option>';
                }
            $html .= '</select>';
        $html .= '</div>';

        return $html;
    }
}