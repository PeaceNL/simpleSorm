<?php

require __DIR__ . '/vendor/autoload.php';

use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;

// Получаем номер телефона из POST запроса
$phoneNumber = $_POST['phoneNumber'];
file_put_contents('request.log', print_r($_POST, true));

$errors = [];
file_put_contents('request.log', print_r($phoneNumber, true));
if ($phoneNumber[0] !== "+") {    
    echo json_encode(['success' => false, "message" => "Номер должен начинаться с +"]);
    exit;    
}

if (strlen($phoneNumber) < 10) {    
    echo json_encode(['success' => false, "message" => "Вы ввели не полный номер"]);
    exit;
}

if (!preg_match('/^\+?\d+$/', $phoneNumber)) {    
    echo json_encode(['success' => false, "message" => "Вы ввели недопустимые символы"]);
    exit;
}

// Валидация номера телефона
$phoneNumberUtil = PhoneNumberUtil::getInstance();

try {
    $numberProto = $phoneNumberUtil->parse($phoneNumber, null);
    $isValid = $phoneNumberUtil->isValidNumber($numberProto);

    if ($isValid) {
        $country = $phoneNumberUtil->getRegionCodeForNumber($numberProto);
        echo json_encode(['success' => true, 'message' => "Действительный номер из: $country"]);
    } else {        
        echo json_encode(['success' => false, "message" => "Недействительный номер"]);
    }
} catch (NumberParseException $e) {    
    echo json_encode(['success' => false, "message" => "Ошбика!"]);
}

