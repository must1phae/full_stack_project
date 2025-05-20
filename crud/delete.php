<?php
include '../connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM etudiant WHERE id=$id");
}

header('Location: home.php');
exit();
?>
