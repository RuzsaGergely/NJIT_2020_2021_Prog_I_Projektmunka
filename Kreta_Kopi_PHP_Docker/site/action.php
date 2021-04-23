<?php
session_start();
include 'database.php';

if($_GET["login"] && $_SERVER["REQUEST_METHOD"] == "POST"){
    $stmt = $conn->prepare("SELECT * FROM `felhasznalok` WHERE `felhasznalonev`=?");
    $stmt->bind_param("s", $_POST["usernamefield"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $sessiondata = Array();
    while($row = $result->fetch_assoc()) {
        $sessiondata[0] = $row["id"];
        $sessiondata[1] = $row["nev"];
        $sessiondata[2] = $row["felhasznalonev"];
        $sessiondata[3] = $row["jelszo"];
    }

    if(password_verify($_POST["passwordfield"], $sessiondata[3])){
        $_SESSION["logged-in"] = true;
        $_SESSION["nev"] = $sessiondata[1];
        header("location: dashboard.php");
    } else {
        session_destroy();
        header("location: index.php");
    }
}