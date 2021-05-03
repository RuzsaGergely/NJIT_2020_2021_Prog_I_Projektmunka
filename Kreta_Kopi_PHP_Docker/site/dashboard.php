<?php
session_start();
if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]){
    header("location: index.php");
}

include 'database.php';

function averageOfClass(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `jegyek`");
    $stmt->execute();
    $result = $stmt->get_result();

    $dividend = 0;
    $divisor = 0;

    while($row = $result->fetch_assoc()) {
        $dividend += ($row["jegy"] * $row["szazalek"]);
        $divisor += $row["szazalek"];
    }

    return $dividend / $divisor;
}
?>

<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kréta Kopi - Főoldal</title>
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
                    <a class="nav-link active" href="dashboard.php">Főoldal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="diakok.php">Diákok</a>
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
        <p>Kérlek, válassz a fenti menüből!</p>
        <h6>Statisztikák</h6>
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th>Osztályátlag</th>
                    <td>
                        <?php
                            echo round(averageOfClass(), 2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" class="text-center">
                        Fakultációs csoportátlag
                    </th>
                </tr>
                <?php
                $stmt = $conn->prepare("SELECT distinct `fakultacio` FROM `tanorak`");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()) {
                    $stmt2 = $conn->prepare("SELECT jegyek.jegy, jegyek.szazalek, jegyek.id FROM jegyek INNER JOIN diakok ON diakok.id = jegyek.diak_id WHERE diakok.fakultacio=?");
                    $stmt2->bind_param("s", $row["fakultacio"]);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $dividend = 0;
                    $divisor = 0;
                    while($row2 = $result2->fetch_assoc()) {
                        $dividend += ($row2["jegy"] * $row2["szazalek"]);
                        $divisor += $row2["szazalek"];
                    }
                    $avg = round($dividend / $divisor,2);
                    echo "<tr><th>{$row["fakultacio"]}</th><td>{$avg}</td></tr>";
                }
                ?>
                <tr>
                    <th colspan="2" class="text-center">
                        Diákok egyéni átlaga
                    </th>
                </tr>
                <?php
                $stmt = $conn->prepare("SELECT `nev`, `id` FROM `diakok`");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()) {
                    $stmt2 = $conn->prepare("SELECT `jegy`, `szazalek` FROM `jegyek` WHERE `diak_id`=?");
                    $stmt2->bind_param('s', $row["id"]);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    $dividend = 0;
                    $divisor = 0;
                    while($row2 = $result2->fetch_assoc()) {
                        $dividend += ($row2["jegy"] * $row2["szazalek"]);
                        $divisor += $row2["szazalek"];
                    }
                    $avg = is_nan(round($dividend / $divisor,2)) ? "!NA!" : round($dividend / $divisor,2);
                    echo "<tr><th>{$row["nev"]}</th><td>{$avg}</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>
