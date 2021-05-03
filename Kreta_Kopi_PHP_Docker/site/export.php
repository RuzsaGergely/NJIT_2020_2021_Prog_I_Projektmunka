<?php
session_start();
if(!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]){
    header("location: index.php");
}

include 'database.php';

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=kreta_kopi_export.txt");

print "# Kréta Kopi Export #\n\n";
print "---------- Diákok átlaga és fakultációja ----------\n\n";
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

    $stmt2 = $conn->prepare("SELECT `fakultacio` FROM `diakok` WHERE `id`=?");
    $stmt2->bind_param('s', $row["id"]);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $fak = "";
    while($row2 = $result2->fetch_assoc()) {
        $fak = $row2["fakultacio"];
    }

    $avg = is_nan(round($dividend / $divisor,2)) ? "!NA!" : round($dividend / $divisor,2);
    print "{$row["nev"]}\t{$fak}\t{$avg}\n";
}
print "\n---------- Adminok listája ----------\n\n";
$stmt = $conn->prepare("SELECT `felhasznalonev` FROM `felhasznalok`");
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    print "{$row["felhasznalonev"]}\n";
}
print "\n---------- Diákok jegyei ----------\n\n";
$stmt = $conn->prepare("SELECT `nev`, `id` FROM `diakok`");
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    print "{$row["nev"]}\n";
    $stmt2 = $conn->prepare("SELECT `jegy`, `szazalek` FROM `jegyek` WHERE `diak_id`=?");
    $stmt2->bind_param('s', $row["id"]);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while($row2 = $result2->fetch_assoc()) {
        print "\t{$row2["jegy"]} - {$row2["szazalek"]}%\n";
    }
}

print "\n---------- Tanórák listája ----------\n\n";
$stmt = $conn->prepare("SELECT * FROM `tanorak`");
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    print "{$row["datum"]}\t{$row["nap"]}\t{$row["fakultacio"]}\t{$row["tanora_anyaga"]}\t{$row["szaktanar"]}\n";
}
