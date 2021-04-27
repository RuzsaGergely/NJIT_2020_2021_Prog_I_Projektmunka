<?php
session_start();
include 'database.php';
if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]){
    header("location: index.php");
}

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
    $stmt = $conn->prepare("UPDATE `jegyek` SET `jegy`=?,`szazalek`=? WHERE `id`=?");
    $stmt->bind_param('sss', $_POST["grade_select"],$_POST["percent_select"], $_GET["grade_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    header("location: jegyek.php?student_selector=".$_GET["redirect_stud"]);
}

if($_GET["add_grade"] && $_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["grade_select"] > 0 && $_POST["percent_select"] > 0){
        $stmt = $conn->prepare("INSERT INTO `jegyek`(`diak_id`, `jegy`, `szazalek`) VALUES (?,?,?)");
        $stmt->bind_param('sss', $_GET["redirect_stud"], $_POST["grade_select"],$_POST["percent_select"]);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    header("location: jegyek.php?student_selector=".$_GET["redirect_stud"]);
}

if($_GET["delete_student"] && isset($_GET["student_id"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    $stmt = $conn->prepare("DELETE FROM `diakok` WHERE `id`=?");
    $stmt->bind_param('s', $_GET["student_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    header("location: diakok.php");
}

if($_GET["add_student"] && $_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["newstudent_name"]) && !empty($_POST["newstudent_class"])){
        $stmt = $conn->prepare("INSERT INTO `diakok` (`nev`, `fakultacio`) VALUES (?,?)");
        $stmt->bind_param('ss', $_POST["newstudent_name"], $_POST["newstudent_class"]);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    header("location: diakok.php");
}

if($_GET["modify_student"] && $_SERVER["REQUEST_METHOD"] == "POST"){
    $stmt = $conn->prepare("UPDATE `diakok` SET `nev`=?,`fakultacio`=? WHERE `id`=?");
    $stmt->bind_param('sss', $_POST["modstudent_name"],$_POST["modstudent_class"], $_GET["student_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    header("location: diakok.php");
}

if($_GET["add_admin"] && $_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST["newadmin_name"]) && !empty($_POST["newadmin_pass"])){
        $stmt = $conn->prepare("INSERT INTO `felhasznalok` (`felhasznalonev`, `jelszo`) VALUES (?,?)");
        $password = password_hash($_POST["newadmin_pass"], PASSWORD_DEFAULT);
        $stmt->bind_param('ss', $_POST["newadmin_name"], $password);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    header("location: admin.php");
}

if($_GET["delete_admin"] && isset($_GET["id"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    $stmt = $conn->prepare("DELETE FROM `felhasznalok` WHERE `id`=?");
    $stmt->bind_param('s', $_GET["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    header("location: admin.php");
}

if($_GET["modify_admin"] && $_SERVER["REQUEST_METHOD"] == "POST"){
    $stmt = $conn->prepare("UPDATE `felhasznalok` SET `jelszo`=? WHERE `id`=?");
    $pass =password_hash($_POST["admin_newpass"], PASSWORD_DEFAULT);
    $stmt->bind_param('ss', $pass, $_GET["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    header("location: admin.php");
}