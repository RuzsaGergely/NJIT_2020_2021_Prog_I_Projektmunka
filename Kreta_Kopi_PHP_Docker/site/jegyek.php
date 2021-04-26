<?php
session_start();
if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]){
    header("location: index.php");
}

include 'database.php';

$student_selected = (isset($_GET["student_selector"]) && is_numeric($_GET["student_selector"]));
?>

<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kréta Kopi - Jegyek</title>
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
                    <a class="nav-link active" href="jegyek.php">Jegyek</a>
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
        <form action="jegyek.php" method="get">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <select name="student_selector" id="student_selector" class="form-control">

                        <?php
                            $stmt = $conn->prepare("SELECT * FROM `diakok`");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $html = "";
                            while($row = $result->fetch_assoc()) {
                                $html = $html . <<<HTML
                                <option value="{$row['id']}">{$row["nev"]}</option>
HTML;

                            }
                            echo $html;
                        ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Szűrés</button>
                </div>
            </div>
        </form>
        <?php
        $stmt = $conn->prepare("SELECT * FROM `diakok` WHERE `id`=?");
        $stmt->bind_param('s', $_GET["student_selector"]);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $html = <<<HTML
            <p class="mt-3">Azon.: {$row["id"]} - Név: {$row["nev"]} - Fakultáció: {$row["fakultacio"]}</p>
HTML;
            echo $html;
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Azon.</th>
                    <th scope="col">Jegy</th>
                    <th scope="col">Százalék</th>
                    <th scope="col">Műveletek</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $stmt = $conn->prepare("SELECT * FROM `jegyek` WHERE `diak_id`=?");
                $stmt->bind_param('s', $_GET["student_selector"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $html = "";
                while($row = $result->fetch_assoc()) {
                    $html = $html . <<<HTML
                    <tr>
                        <th scope="row">{$row["id"]}</th>
                        <td>{$row["jegy"]}</td>
                        <td>{$row["szazalek"]}%</td>
                        <td><button class="btn btn-danger" onclick="javascript:window.location.href ='action.php?delete_grade=true&grade_id={$row["id"]}&redirect_stud={$_GET["student_selector"]}'">Törlés</button></td>
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
