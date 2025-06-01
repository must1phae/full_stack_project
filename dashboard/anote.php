<?php
include '../connect.php'; 
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:../login.php");
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

// Récupérer toutes les notes pour affichage + création texte notes pour chatbot
$notesQuery = mysqli_query($conn, "SELECT * FROM note WHERE id = $id_M");
$notes = [];
$notesText = "";
while ($note = mysqli_fetch_assoc($notesQuery)) {
    $notes[] = $note;
    $notesText .= "- " . $note['note'] . "\n";
}

// Traitement du formulaire d'ajout de note
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $note = floatval($_POST['note']);

    // Insertion dans la base de données
    $insertQuery = mysqli_query($conn, "INSERT INTO note (id, note) VALUES ($id_M, $note)");

    if ($insertQuery) {
        header("Location: note.php?id_M=$id_M"); // Redirige vers la même page pour afficher la note ajoutée
        exit;
    } else {
        $error = "Erreur lors de l'insertion de la note.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une note à <?= htmlspecialchars($module['nom']) ?></title>
    <link rel="stylesheet" href="../crud/style.css">
</head>
<body>

<h1>Ajouter une note pour le module : <?= htmlspecialchars($module['nom']) ?></h1>

<a class="retour" href="home.php">acceuil</a>
 <a class="retour" href="note.php?id_M=<?= $id_M ?>">ajouter</a>

<?php if (isset($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

 

<h2>Liste des notes</h2>

<?php if (empty($notes)): ?>
    <p class="mm">Aucune note trouvée pour ce module.</p>
<?php else: ?>
    <ul>
        <?php foreach ($notes as $note): ?>
            <li class="lesnotes">
                <?= htmlspecialchars($note['note']) ?>
                <a class="ede" href="edit.php?id_n=<?= $note['id_n'] ?>">✏️ Edit</a>
                <a class="delete" href="delete.php?id_n=<?= $note['id_n'] ?>&id_M=<?= $id_M ?>" onclick="return confirm('Supprimer cette note ?')">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!-- Chatbot -->
<div id="chatbotIcon" title="Chat avec l'IA">🤖</div>

<div id="chatbotWindow" style="display:none;">
    <div class="close-btn" id="closeChatbot">✖️ Fermer</div>
    <div id="chatbotBody">
        <div id="chatbotResponse">Que puis-je faire pour vous ?</div>
        <div id="chatbotActions">
            <button class="chatbot-action" data-action="summarize">📚 Résumé</button>
            <button class="chatbot-action" data-action="define">📖 Définitions</button>
            <button class="chatbot-action" data-action="quiz">❓ Quiz</button>
        </div>
    </div>
</div>

<script>
    const notesForChatbot = `<?= addslashes($notesText) ?>`;
    const currentModuleNameForChatbot = "<?= addslashes($module['nom']) ?>";
</script>
<script src="chatbot.js"></script>

</body>
</html>
