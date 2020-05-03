(function() {
    var birthdateInput = document.getElementById("birthdate");
    birthdateInput.addEventListener("input", onBirthdateChangeEvent);
})();

function onBirthdateChangeEvent(e) {
    var birthDate = e.target.value;
    var zodiacSignField = document.getElementById("zodiac_sign");
    var invalidFormatMessage = "Моля въведете валидна дата във формат ГГГГ-ММ-ДД";

    if (!birthDate.match(/[0-9]{4}[\-/\.][0-9]{2}[\-/\.][0-9]{2}/)) {
        zodiacSignField.value = invalidFormatMessage;
        return;
    }

    var ymd = birthDate.split("-");
    var y = parseInt(ymd[0]), m = parseInt(ymd[1]), d = parseInt(ymd[2]);

    if (m == 1 && (d >= 20 && d <= 31) || m == 2 && (d >= 1 && d <= 18)) {
        zodiacSignField.value = "Водолей";
    } else if (m == 2 && (d >= 19 && d <= 29) || m == 3 && (d >= 1 && d <= 20)) {
        zodiacSignField.value = "Риби";
    } else if (m == 3 && (d >= 21 && d <= 31) || m == 4 && (d >= 1 && d <= 19)) {
        zodiacSignField.value = "Овен";
    } else if (m == 4 && (d >= 20 && d <= 30) || m == 5 && (d >= 1 && d <= 20)) {
        zodiacSignField.value = "Телец";
    } else if (m == 5 && (d >= 21 && d <= 31) || m == 6 && (d >= 1 && d <= 21)) {
        zodiacSignField.value = "Близнаци";
    } else if (m == 6 && (d >= 22 && d <= 30) || m == 7 && (d >= 1 && d <= 22)) {
        zodiacSignField.value = "Рак";
    } else if (m == 7 && (d >= 23 && d <= 31) || m == 8 && (d >= 1 && d <= 22)) {
        zodiacSignField.value = "Лъв";
    } else if (m == 8 && (d >= 23 && d <= 31) || m == 9 && (d >= 1 && d <= 22)) {
        zodiacSignField.value = "Дева";
    } else if (m == 9 && (d >= 23 && d <= 30) || m == 10 && (d >= 1 && d <= 22)) {
        zodiacSignField.value = "Везни";
    } else if (m == 10 && (d >= 23 && d <= 31) || m == 11 && (d >= 1 && d <= 21)) {
        zodiacSignField.value = "Скорпион";
    } else if (m == 11 && (d >= 22 && d <= 30) || m == 12 && (d >= 1 && d <= 21)) {
        zodiacSignField.value = "Стрелец";
    } else if (m == 12 && (d >= 22 && d <= 31) || m == 1 && (d >= 1 && d <= 19)) {
        zodiacSignField.value = "Козирог";
    } else {
        zodiacSignField.value = invalidFormatMessage;
    }
}
