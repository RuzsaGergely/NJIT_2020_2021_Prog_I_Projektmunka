<?php
$servername = "mariadb";
$username = "admin";
$password = "admin";
$dbname = "database1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $error_msg = <<<HTML
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <div class="card" style="margin-left: 30%; margin-right: 30%; margin-top:5%">
      <div class="card-body">
        <h1 class="text-center">Hiba történt</h1>
        <p class="text-center">Adatbázis hiba következett be, amely miatt az oldal további működése akadályoztatva van. Kérjük, értesítse a rendszergazdát vagy a helyi illetékest!</p>
        <div class="card">
            <div class="card-header">
            Hibaüzenet
          </div>
          <div class="card-body bg-danger text-light">
            {$conn->connect_error}
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
HTML;

    die($error_msg);
}
$utfstmt = $conn->prepare("SET NAMES 'utf8'");
$utfstmt->execute();

