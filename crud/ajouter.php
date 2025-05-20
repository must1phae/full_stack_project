<?php
include '../connect.php';
session_start();
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../admin.php");
    exit;
} 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];

    $conn->query("INSERT INTO etudiant (password, Nom, prenom, username) VALUES ('$password', '$nom', '$prenom', '$username')");
    header('Location: home.php');
    exit();
}
?>
<link rel="stylesheet" href="style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<form method="post">
    <h2>ajouter des etudiant</h2>

<h3>family name</h3>    
<div><input type="text" name="nom" required><br></div>
    
    <h3>name</h3>
    <div> <input type="text" name="prenom" required><br></div>
    
    <h3>username</h3>
    <div><input type="text" name="username" required><br></div>
     
    <h3>password</h3>
    <div><input type="text" name="password" required><br></div>
  
    <input type="submit" value="add">
</form>
