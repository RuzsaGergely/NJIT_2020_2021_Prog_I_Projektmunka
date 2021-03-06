<?php
session_start();
if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]){
    header("location: index.php");
}
include 'database.php';
if($_GET["modify_grade"] && isset($_GET["grade_id"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    $stmt = $conn->prepare("SELECT * FROM `jegyek` WHERE `id`=?");
    $stmt->bind_param("s", $_GET["grade_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $grade_data = Array();
    while($row = $result->fetch_assoc()) {
        $grade_data[0] = $row["id"];
        $grade_data[1] = $row["jegy"];
        $grade_data[2] = $row["szazalek"];
    }
} else {
    header("location: jegyek.php");
}
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kréta Kopi - Jegymódosítás</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Kréta Kopi</span>
    </div>
</nav>
<form action="action.php?modify_grade=true&redirect_stud=<?php echo $_GET["redirect_stud"] . "&grade_id=".$_GET["grade_id"];?>" method="post">
    <div class="row g-3 align-items-center mt-3 ms-3">
        <div class="col-auto">
            <select name="grade_select" id="grade_select" class="form-select">
            <?php
                $grades = Array(1,2,3,4,5);
                foreach ($grades as $selection) {
                    $selected = ($grade_data[1] == $selection) ? "selected" : "";
                    echo '<option '.$selected.' value="'.$selection.'">'.$selection.'</option>';
                }
            ?>
            </select>
        </div>
        <div class="col-auto">
            <select name="percent_select" id="percent_select" class="form-select">
                <?php
                $grades = Array(50,100,150,200);
                foreach ($grades as $selection) {
                    $selected = ($grade_data[2] == $selection) ? "selected" : "";
                    echo '<option '.$selected.' value="'.$selection.'">'.$selection.'%</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success">Mentés</button>
        </div>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>
