<?php
include 'database.php';

$stmt = $conn->prepare("INSERT INTO `felhasznalok` (`felhasznalonev`, `jelszo`) VALUES (?,?)");
$ranpass = generateRandomString(15);
$password = password_hash($ranpass, PASSWORD_DEFAULT);
$admin_username = "admin";
$stmt->bind_param('ss', $admin_username, $password);

if($stmt->execute()){
    echo "Felhasználóneved: admin - Jelszavad: {$ranpass}";
} else {
    echo "Hiba történt. Valószínűleg már létezik az admin felhasználó!";
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}