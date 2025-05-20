<?php
include '../connect.php'; // Make sure this sets up $conn as a mysqli connection
 
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../login.php");
    //si l'utilisateur est deja connnecter il il peut entrer directement vers admin.php 
    exit;
} 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $stmt = mysqli_prepare($conn, "INSERT INTO module (nom) VALUES (?)");
    mysqli_stmt_bind_param($stmt, "s", $nom);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('Location: home.php');
    exit;
}
?>
<head>
    <link rel="stylesheet" href="../crud/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
</head>
<h2>Ajouter un module</h2>
<form method="POST">
    Nom du module : <input type="text" name="nom" required>
    <button type="submit">Ajouter</button>
</form>
