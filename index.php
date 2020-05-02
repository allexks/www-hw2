<?php

require_once "config/config.php";

define("FIRSTNAME_FIELDNAME", "firstname");
define("FAMILYNAME_FIELDNAME", "familyname");

$errors = [];

$field_values = [
    FIRSTNAME_FIELDNAME => "",
    FAMILYNAME_FIELDNAME => "",
];

function empty_field_error_message($field) {
    switch ($field) {
        case FIRSTNAME_FIELDNAME:
            return "Моля попълнете името си!";
        case FAMILYNAME_FIELDNAME:
            return "Моля попълнете фамилното си име!";
    }
}

if (isset($_POST["submit"])) {

    foreach ($field_values as $field_name => $field_default_value) {
        $value = $_POST[$field_name] ?? $field_default_value;

        if (empty($value)) {
            $errors[] = empty_field_error_message($field_name);
        } else {
            $field_values[$field_name] = $value;
        }
    }

    if (empty($errors)) {

        // TODO: save into database

        header("Location: success.php");
    }
}

$error_html = implode("<br />", $errors);

$template_dir = SETTINGS["TEMPLATES_DIR"] . "/" . SETTINGS["TEMPLATE_NAME"];
include "$template_dir/index.html";
