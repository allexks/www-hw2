<?php

require_once "config/config.php";

define("FIRSTNAME_FIELDNAME", "firstname");
define("FAMILYNAME_FIELDNAME", "familyname");
define("MAJOR_FIELDNAME", "major");
define("ACADEMIC_YEAR_FIELDNAME", "academic_year");
define("FN_FIELDNAME", "faculty_number");
define("MAJORGROUP_FIELDNAME", "major_group");
define("BIRTHDATE_FIELDNAME", "birth_date");
define("LINK_FIELDNAME", "hyperlink");

$errors = [];

$field_values = [
    FIRSTNAME_FIELDNAME => "",
    FAMILYNAME_FIELDNAME => "",
    MAJOR_FIELDNAME => "",
    ACADEMIC_YEAR_FIELDNAME => "",
    FN_FIELDNAME => "",
    MAJORGROUP_FIELDNAME => "",
    BIRTHDATE_FIELDNAME => "",
    LINK_FIELDNAME => "",
];

function empty_field_error_message($field) {
    switch ($field) {
        case FIRSTNAME_FIELDNAME:
            return "Моля попълнете името си!";
        case FAMILYNAME_FIELDNAME:
            return "Моля попълнете фамилното си име!";
        case MAJOR_FIELDNAME:
            return "Моля попълнете специалността си!";
        case ACADEMIC_YEAR_FIELDNAME:
            return "Моля попълнете в кой курс сте (1, 2, 3, ...)!";
        case FN_FIELDNAME:
            return "Моля попълнете факултетния си номер!";
        case MAJORGROUP_FIELDNAME:
            return "Моля попълнете номера на групата, в която сте!";
        case BIRTHDATE_FIELDNAME:
            return "Моля попълнете датата си на раждане!";
        case LINK_FIELDNAME:
            return "Моля оставете ваш линк към личен уебсайт, блог или профил в социална мрежа!";
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
