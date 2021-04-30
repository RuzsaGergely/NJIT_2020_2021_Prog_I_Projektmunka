<?php
session_start();
if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]){
    header("location: index.php");
}
include 'database.php';
if(isset($_GET["class_id"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    $stmt = $conn->prepare("SELECT * FROM `tanorak` WHERE `id`=?");
    $stmt->bind_param("s", $_GET["class_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $class_data = Array();
    while($row = $result->fetch_assoc()) {
        $class_data[0] = $row["id"];
        $class_data[1] = $row["datum"];
        $class_data[2] = $row["fakultacio"];
        $class_data[3] = $row["tanora_anyaga"];
        $class_data[4] = $row["szaktanar"];
    }
} else {
    header("location: tanorak.php");
}
?>
<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kréta Kopi - Admin jelszó csere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Kréta Kopi</span>
    </div>
</nav>
<form action="action.php?modify_class=true&id=<?php echo $_GET["class_id"]; ?>" method="post">
    <div class="row g-3 align-items-center mt-3 ms-3">
        <div class="col-auto">
            <input type="text" class="form-control" id="modifyclass_subject" name="modifyclass_subject" placeholder="Tanóra anyaga" value="<?php echo  $class_data[3];?>">
        </div>
        <div class="col-auto">
            <select name="modifyclass_class" id="modifyclass_class" class="form-select">
                <?php
                $grades = Array("hálózatok I.", "Hálózatok I. - gyakorlat", "Irodai informatika", "Irodai informatika - gyakorlat", "Linux alapok", "Linux alapok - gyakorlat", "Programozás", "Programozás - gyakorlat");
                foreach ($grades as $selection) {
                    $selected = ($class_data[2] == $selection) ? "selected" : "";
                    echo '<option '.$selected.' value="'.$selection.'">'.$selection.'</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <select name="modifyclass_teacher" id="modifyclass_teacher" class="form-select">
                <?php
                $stmt = $conn->prepare("SELECT distinct `szaktanar` FROM `tanorak`");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()) {
                    if($class_data[4] == $row["szaktanar"]){
                        echo "<option value='{$row["szaktanar"]}' selected>{$row["szaktanar"]}</option>";

                    } else {
                        echo "<option value='{$row["szaktanar"]}'>{$row["szaktanar"]}</option>";

                    }
                }
                ?>
            </select>
        </div>
        <div class="col-auto">
            <input type="date" class="form-control" id="modifyclass_date" name="modifyclass_date" value="<?php echo str_replace(".", "", str_replace(". ", "-", $class_data[1]));?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success">Frissítés</button>
        </div>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>
