<?php
include '../connect.php'; // Assure que $conn est votre connexion mysqli
 
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../login.php");
    //si l'utilisateur est deja connnecter il il peut entrer directement vers admin.php 
    exit;
} 


// Récupération des modules
$result = mysqli_query($conn, "SELECT * FROM module ORDER BY nom ASC");
$modules = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($module = mysqli_fetch_assoc($result)) {
        $modules[] = $module; // Ne récupère plus les notes ici
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../crud/style.css">
    <title>Dashboard - Modules</title>
</head>
<body>

<h1 class="das">Dashboard des Modules</h1>
<div style="text-align: right; margin: 10px;">
    <a class="logout" href="../crud/logout.php" >
     logout
    </a>
</div>
<p class="ajouterm"><a href="module.php">+ Ajouter un module</a></p>

<article class="bod">
    <?php if (empty($modules)): ?>
        <p class="mm">Aucun module trouvé.</p>
    <?php else: ?>
        <?php foreach ($modules as $module): ?>
          <div class="module">
    <strong><?= htmlspecialchars($module['nom']) ?></strong><br>

    <a href="note.php?id_M=<?= $module['id_M'] ?>">Ajouter une note</a>  
    <a href="anote.php?id_M=<?= $module['id_M'] ?>" class="btn">Afficher les notes</a>  
    
         <a href="edit.php?id_M=<?= $module['id_M'] ?>">✏️ Modifier</a>
    <a class="delete" href="delete.php?delete_module=<?= $module['id_M'] ?>" onclick="return confirm('Supprimer ce module et toutes ses notes ?')">Supprimer le module</a>
   
 
   
    <hr>
</div>

        <?php endforeach; ?>
    <?php endif; ?>
</article>

</body>
</html>