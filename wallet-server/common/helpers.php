<?php
function validateInput($data, $fields) {
    $errors = [];

    foreach ($fields as $field) {
        if (empty($data[$field])) {
            $errors[] = "$field is required";
        }
    }

    return $errors;
}

?>