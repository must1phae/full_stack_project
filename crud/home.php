<?php
include '../connect.php';
 
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../admin.php");
    //si l'utilisateur est deja connnecter il il peut entrer directement vers admin.php 
    exit;
} 
 

 

// Récupérer tous les étudiants
$result = $conn->query("SELECT * FROM etudiant");//recuperer les etudient de la base de donnée 
?>
<link rel="stylesheet" href="style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div style="text-align: right; margin: 10px;">
    <a class="logout" href="logout.php" >
     logout
    </a>
</div>
<h2 id="title">table des etudiants</h2>
 
<table border="1" cellpadding="10">
    <tr class="tableau">
        <th>ID</th>

        <th>family name</th>
        <th>name</th>
        <th>Username</th>
        <th>Password</th>
        <th>Actions</th>
    </tr>
    

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr class="row">
            <td><?= $row['id'] ?></td>
            <td><?= $row['Nom'] ?></td>
            <td><?= $row['prenom'] ?></td>   
            <td><?= $row['username'] ?></td>
            <td><?= $row['password'] ?></td>
            
            <td>
                <a class="edit" href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a class="delete" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table><a class="add" href="ajouter.php"><i class="fa fa-plus"></i>add_new</a>