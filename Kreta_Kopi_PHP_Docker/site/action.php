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

if($_GET["delete_grade"] && isset($_GET["grade_id"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    $stmt = $conn->prepare("DELETE FROM `jegyek` WHERE `id`=?");
    $stmt->bind_param('s', $_GET["grade_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    header("location: jegyek.php?student_selector=".$_GET["redirect_stud"]);
}

if($_GET["modify_grade"] && $_SERVER["REQUEST_METHOD"] == "POST"){

}