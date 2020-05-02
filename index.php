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

    $db = null;

    if (empty($errors)) {
        $db_host = SETTINGS["DATABASE_HOST"];
        $db_user = SETTINGS["DATABASE_USER"];
        $db_pass = SETTINGS["DATABASE_PASSWORD"];
        $db_name = SETTINGS["DATABASE_NAME"];

        try {
            $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        } catch (PDOException $exception) {
            error_log("[!!] FATAL: Database connection unsucessful: " . $exception->getMessage());
            $errors[] = "Изникна ни проблем. Пробвайте пак по-късно.";
        }
    }

    if (empty($errors) && isset($db)) {
        $qry = "INSERT INTO users (
                    first_name,
                    family_name,
                    academic_year,
                    major,
                    fn,
                    major_group,
                    birth,
                    zodiac_sign,
                    hyperlink,
                    photo_filepath,
                    motivation
                ) VALUES (
                    :firstname,
                    :familyname,
                    :year,
                    :major,
                    :fn,
                    :majorgroup,
                    :birth,
                    :zodiac,
                    :hyperlink,
                    :photo,
                    :motivation
                )";

        $stmt = $db->prepare($qry);

        $stmt->bindParam(":firstname", $field_values[FIRSTNAME_FIELDNAME]);
        $stmt->bindParam(":familyname", $field_values[FAMILYNAME_FIELDNAME]);
        $stmt->bindParam(":year", $field_values[ACADEMIC_YEAR_FIELDNAME]);
        $stmt->bindParam(":major", $field_values[MAJOR_FIELDNAME]);
        $stmt->bindParam(":fn", $field_values[FN_FIELDNAME]);
        $stmt->bindParam(":majorgroup", $field_values[MAJORGROUP_FIELDNAME]);
        $stmt->bindParam(":birth", $field_values[BIRTHDATE_FIELDNAME]);
        $zodiac = "LIBRA";  // TODO
        $stmt->bindParam(":zodiac", $zodiac);
        $stmt->bindParam(":hyperlink", $field_values[LINK_FIELDNAME]);
        $photo = "test.png"; // TODO
        $stmt->bindParam(":photo", $photo);
        $motivation = "none"; // TODO
        $stmt->bindParam(":motivation", $motivation);

        if (!$stmt->execute()) {
            error_log("[!!] CRITICAL: Database query unsucessful: " . $stmt->errorInfo()[2]);
            $errors[] = "Изникна ни проблем със заявката. Пробвайте пак по-късно.";
        }
    }

    if (empty($errors)) {
        header("Location: success.php");
    }
}

$error_html = implode("<br />", $errors);

$template_dir = SETTINGS["TEMPLATES_DIR"] . "/" . SETTINGS["TEMPLATE_NAME"];
include "$template_dir/index.html";
