<?php
include '../connect.php';
session_start();
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../admin.php");
    exit;
} 
// Vérifie si l'ID de l'étudiant est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM etudiant WHERE id=$id");
    $etudiant = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];

    $conn->query("UPDATE etudiant SET password='$password', Nom='$nom', prenom='$prenom', username='$username' WHERE id=$id");
    header('Location: home.php');
    exit();
}
?>
<link rel="stylesheet" href="style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta charset="UTF-8">
<form method="post">
    <h2>modify students </h2>
    <input type="hidden" name="id" value="<?= $etudiant['id'] ?>">
    <h3>family name</h3>
    <div>

        <input type="text" name="nom" value="<?= $etudiant['Nom'] ?>" required><br>
    </div>
    <h3>name</h3>
    <div> <input type="text" name="prenom" value="<?= $etudiant['prenom'] ?>" required><br></div>
    <h3>username</h3>
    <div>

         
        <input type="text" name="username" value="<?= $etudiant['username'] ?>" required><br>
    </div>
    <h3>password</h3>
    <div>

        

        <input type="text" name="password" value="<?= $etudiant['password'] ?>" required><br>
    </div>




    <input type="submit" value="Modify">
</form>