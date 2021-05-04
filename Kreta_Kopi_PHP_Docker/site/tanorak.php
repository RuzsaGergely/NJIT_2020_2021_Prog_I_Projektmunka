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
    <title>Kréta Kopi - Tanórák</title>
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
                    <a class="nav-link" href="diakok.php">Diákok</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jegyek.php">Jegyek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="tanorak.php">Tanórák</a>
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
        <div class="mt-3 mb-4">
            <p><b>Óra naplózása</b></p>
            <form action="action.php?add_class=true" method="post">
                <div class="row g-3 align-items-center mt-3 ms-3">
                    <div class="col-auto">
                        <input type="text" class="form-control" id="newclass_subject" name="newclass_subject" placeholder="Tanóra anyaga">
                    </div>
                    <div class="col-auto">
                        <select name="newclass_class" id="newclass_class" class="form-select">
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
                        <select name="newclass_teacher" id="newclass_teacher" class="form-select">
                            <?php
                            $stmt = $conn->prepare("SELECT distinct `szaktanar` FROM `tanorak`");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='{$row["szaktanar"]}'>{$row["szaktanar"]}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" id="newclass_date" name="newclass_date">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success">Hozzáadás</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Azon.</th>
                    <th scope="col">Dátum</th>
                    <th scope="col">Fakultáció</th>
                    <th scope="col">Tanóra anyaga</th>
                    <th scope="col">Szaktanár</th>
                    <th scope="col">Műveletek</th>

                </tr>
                </thead>
                <tbody>

                <?php
                $stmt = $conn->prepare("SELECT * FROM `tanorak`");
                $stmt->execute();
                $result = $stmt->get_result();
                $html = "";
                while($row = $result->fetch_assoc()) {
                    $html = $html . <<<HTML
                    <tr>
                        <th class="align-middle" scope="row">{$row["id"]}</th>
                        <td class="align-middle">{$row["datum"]} - {$row["nap"]}</td>
                        <td class="align-middle">{$row["fakultacio"]}</td>
                        <td class="align-middle">{$row["tanora_anyaga"]}</td>
                        <td class="align-middle">{$row["szaktanar"]}</td>
                        <td class="align-middle"><button class="btn btn-danger" onclick="javascript:window.location.href ='action.php?delete_class=true&class_id={$row["id"]}'">Törlés</button><br><button class="btn btn-warning mt-2" onclick="javascript:window.location.href ='tanoramodositas.php?class_id={$row["id"]}'">Módosítás</button></td>
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
