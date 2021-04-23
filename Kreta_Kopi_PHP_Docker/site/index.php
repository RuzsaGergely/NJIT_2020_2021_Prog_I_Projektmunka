<?php
session_start();

if(isset($_SESSION["logged-in"]) && $_SESSION["logged-in"]){
    header("location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kréta Kopi - Bejelentkezés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <link rel="stylesheet" href="assets/signin.css">
</head>
<body class="text-center">
    <main class="form-signin">
        <form action="action.php?login=true" method="post">
            <img class="mb-4" src="assets/10012019-19.svg" alt="" width="100" height="100">
            <h1 class="h3 mb-3 fw-normal">Jelentkezz be!</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="loginUsername" name="usernamefield" placeholder="teszt.elek">
                <label for="loginUsername">Felhasználónév</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="loginPassword" name="passwordfield" placeholder="********">
                <label for="loginPassword">Jelszó</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Bejelentkezés</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
        </form>
    </main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>