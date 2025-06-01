<?php
include '../connect.php';
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../login.php");
    //si l'utilisateur est deja connnecter il il peut entrer directement vers admin.php 
    exit;
} 
// MODIFIER UN MODULE
if (isset($_GET['id_M'])) {
    $id_M = intval($_GET['id_M']);

    // Traitement du formulaire pour le module
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
        $nom = $_POST['nom'];
        $stmt = mysqli_prepare($conn, "UPDATE module SET nom = ? WHERE id_M = ?");
        mysqli_stmt_bind_param($stmt, "si", $nom, $id_M);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: home.php");
        exit;
    }

    // Afficher les infos du module
    $result = mysqli_query($conn, "SELECT * FROM module WHERE id_M = $id_M");
    $module = mysqli_fetch_assoc($result);
    if (!$module) die("Module introuvable.");
    ?>
<link rel="stylesheet" href="../crud/style.css">
    <h2>Modifier le module</h2>
    <form method="POST">
        <input type="text" name="nom" value="<?= htmlspecialchars($module['nom']) ?>" required>
        <button type="submit">Enregistrer</button>
    </form>
    <a href="home.php">Annuler</a>

<?php
 

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../login.php");
    //si l'utilisateur est deja connnecter il il peut entrer directement vers admin.php 
    exit;
} 
} elseif (isset($_GET['id_n'])) {
    $id_n = intval($_GET['id_n']);

    // Traitement du formulaire pour la note
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note'])) {
        $note = $_POST['note'];
        $id_M = intval($_POST['id_M']);
        $stmt = mysqli_prepare($conn, "UPDATE note SET note = ? WHERE id_n = ?");
        mysqli_stmt_bind_param($stmt, "si", $note, $id_n);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: anote.php?id_M=$id_M");
        exit;
    }

    // Afficher la note
    $result = mysqli_query($conn, "SELECT * FROM note WHERE id_n = $id_n");
    $note = mysqli_fetch_assoc($result);
    if (!$note) die("Note introuvable.");
    ?>
<link rel="stylesheet" href="../crud/style.css">
    
    <h2>Modifier la note</h2>
    <form method="POST">
        <textarea name="note" required><?= htmlspecialchars($note['note']) ?></textarea>
        <input type="hidden" name="id_M" value="<?= $note['id'] ?>">
        <button type="submit">Enregistrer</button>
    </form>
    <a class="annuler" href="anote.php?id_M=<?= $note['id'] ?>">Annuler</a>

<?php
} else {
    echo "Aucun ID fourni.";
}
?>
