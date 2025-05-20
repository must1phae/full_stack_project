<?php
include '../connect.php'; // Assumes $conn is your mysqli connection
 
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../login.php");
    //si l'utilisateur est deja connnecter il il peut entrer directement vers admin.php 
    exit;
} 
 
$id_M = $_GET['id_M'] ?? null;
if (!$id_M) {
    die("Module non spécifié.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $_POST['note'];
    // Correction ici : la colonne doit être 'id_M'
    $stmt = mysqli_prepare($conn, "INSERT INTO note (note, id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "si", $note, $id_M);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: anote.php?id_M=$id_M");

}
?>
<head>
    <link rel="stylesheet" href="../crud/style.css">
</head>
<h2>Ajouter des notes pour le module</h2><a class="retour"  href="home.php">Retour à l’accueil</a>

<form method="POST">
    <h2>note</h2>
      <textarea name="note" required></textarea>
    <button type="submit" >Ajouter la note</button>
</form>

