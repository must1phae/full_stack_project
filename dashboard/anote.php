<?php
include '../connect.php'; // Assurez-vous que la connexion fonctionne
 
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../login.php");
    //si l'utilisateur est deja connnecter il il peut entrer directement vers admin.php 
    exit;
} 
 
// Vérifier si l'ID du module est passé
if (!isset($_GET['id_M']) || empty($_GET['id_M'])) {
    echo "ID du module manquant.";
    exit;
}

$id_M = intval($_GET['id_M']);

// Récupérer les informations du module
$moduleQuery = mysqli_query($conn, "SELECT * FROM module WHERE id_M = $id_M");
$module = mysqli_fetch_assoc($moduleQuery);

if (!$module) {
    echo "Module non trouvé.";
    exit;
}

// Récupérer les notes associées
$notesQuery = mysqli_query($conn, "SELECT * FROM note WHERE id = $id_M");
$notes = [];
while ($note = mysqli_fetch_assoc($notesQuery)) {
    $notes[] = $note;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notes du module <?= htmlspecialchars($module['nom']) ?></title>
    <link rel="stylesheet" href="../crud/style.css">
</head>
<body>

<h1>Notes pour le module : <?= htmlspecialchars($module['nom']) ?></h1>

<a class="retour" href="home.php">← Retour</a>
<a class="n" href="note.php?id_M=<?= $module['id_M'] ?>">Ajouter une note</a> 
<?php if (empty($notes)): ?>
    <p class="mm">Aucune note trouvée pour ce module.</p>
<?php else: ?>
 <ul>
    <?php foreach ($notes as $note): ?>
        <li class="lesnotes">
            <?= htmlspecialchars($note['note']) ?><a class="ede" href="edit.php?id_n=<?= $note['id_n'] ?>">✏️edit</a>
            <a class="delete" href="delete.php?id_n=<?= $note['id_n'] ?>&id_M=<?= $id_M ?>" onclick="return confirm('Supprimer cette note ?')">Supprimer</a>

        
        </li>
    <?php endforeach; ?>
</ul>

<?php endif; ?>
 


</body>
</html>
