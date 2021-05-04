<?php
session_start();
if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]){
    header("location: index.php");
}

include 'database.php';
?>

<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kréta Kopi - Diákok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Kréta Kopi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Főoldal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="diakok.php">Diákok</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jegyek.php">Jegyek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tanorak.php">Tanórák</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Kijelentkezés</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="card mt-3">
    <div class="card-body">
        <b>Diákok kezelése</b>
        <form action="action.php?add_student=true" method="post" class="mb-4">
            <div class="row g-3 align-items-center mt-3 ms-3">
                <div class="col-auto">
                    <input type="text" class="form-control" id="newstudent_name" name="newstudent_name" placeholder="Minta Áron">
                </div>
                <div class="col-auto">
                    <select name="newstudent_class" id="newstudent_class" class="form-select">
                        <?php
                        $stmt = $conn->prepare("SELECT distinct `fakultacio` FROM `tanorak`");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='{$row["fakultacio"]}'>{$row["fakultacio"]}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Hozzáadás</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Azon.</th>
                    <th scope="col">Név</th>
                    <th scope="col">Fakultáció</th>
                    <th scope="col">Műveletek</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $stmt = $conn->prepare("SELECT * FROM `diakok`");
                $stmt->execute();
                $result = $stmt->get_result();
                $html = "";
                while($row = $result->fetch_assoc()) {
                    $html = $html . <<<HTML
                    <tr>
                        <th class="align-middle" scope="row">{$row["id"]}</th>
                        <td class="align-middle">{$row["nev"]}</td>
                        <td class="align-middle">{$row["fakultacio"]}</td>
                        <td class="align-middle"><button class="btn btn-danger" onclick="javascript:window.location.href ='action.php?delete_student=true&student_id={$row["id"]}'">Törlés</button><button class="btn btn-warning ms-3" onclick="javascript:window.location.href ='diakmodositas.php?modify_student=true&student_id={$row["id"]}'">Módosítás</button></td>
                    </tr>
HTML;
                }
                echo $html;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>
