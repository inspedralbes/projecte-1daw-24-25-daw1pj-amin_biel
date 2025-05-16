<?php
require "../connexio.php"; 

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("<script>alert('Error: No s\'ha proporcionat cap ID d\'incidència.'); window.history.back();</script>");
}

$id_incidencia = intval($_GET["id"]);

$sql_check = "SELECT ID_ESTAT FROM INCIDENCIES WHERE ID_INCIDENCIA = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $id_incidencia);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row = $result_check->fetch_assoc();

if (!$row) {
    die("<script>alert('Error: La incidència no existeix.'); window.history.back();</script>");
}

if ($row["ID_ESTAT"] != 3) {  
    die("<script>alert('Només es poden esborrar incidències que estiguin acabades.'); window.history.back();</script>");
}

$sql_delete_actuacio = "DELETE FROM ACTUACIO_INCIDENCIA WHERE ID_INCIDENCIA = ?";
$stmt_delete_actuacio = $conn->prepare($sql_delete_actuacio);
$stmt_delete_actuacio->bind_param("i", $id_incidencia);
$stmt_delete_actuacio->execute();

$sql_delete = "DELETE FROM INCIDENCIES WHERE ID_INCIDENCIA = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id_incidencia);

if ($stmt_delete->execute()) {
    echo "<script>alert('Incidència esborrada correctament!'); window.location.href='llistat.php';</script>";
    exit();
} else {
    echo "<script>alert('Error en esborrar la incidència: " . $conn->error . "'); window.history.back();</script>";
}

$conn->close();
?>
